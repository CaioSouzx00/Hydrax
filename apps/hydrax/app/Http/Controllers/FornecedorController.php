<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fornecedor\StoreFornecedorRequest;
use App\Models\FornecedorPendente;
use App\Models\Fornecedor;
use App\Services\Novu\NovuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ProdutoFornecedor;
use App\Models\Avaliacao;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Fornecedores", description: "Operações relacionadas aos fornecedores (parceiros)")]
class FornecedorController extends Controller
{
    protected NovuService $novuService;

    public function __construct(NovuService $novuService)
    {
        $this->novuService = $novuService;
    }

    /**
     * Exibe o formulário de login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('fornecedores.login');
    }

    /**
     * Exibe o formulário de cadastro.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('fornecedores.create');
    }

    #[OA\Post(path: "/fornecedores", summary: "Cadastra um novo fornecedor (aguarda aprovação)", tags: ["Fornecedores"])]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: "multipart/form-data",
            schema: new OA\Schema(
                required: ["nome_empresa", "cnpj", "email", "telefone", "password"],
                properties: [
                    new OA\Property(property: "nome_empresa", type: "string"),
                    new OA\Property(property: "cnpj", type: "string"),
                    new OA\Property(property: "email", type: "string", format: "email"),
                    new OA\Property(property: "telefone", type: "string"),
                    new OA\Property(property: "password", type: "string", format: "password"),
                    new OA\Property(property: "foto", type: "string", format: "binary"),
                ]
            )
        )
    )]
    #[OA\Response(response: 302, description: "Redireciona para o login de fornecedores")]
    public function store(StoreFornecedorRequest $request)
    {
        $dados = $request->validated();

        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fornecedores', 'public');
        }

        FornecedorPendente::create([
            'nome_empresa' => $dados['nome_empresa'],
            'cnpj' => $dados['cnpj'],
            'email' => $dados['email'],
            'telefone' => $dados['telefone'],
            'password' => $dados['password'], // ainda não usa Hash
            'status' => 'pendente',
            'foto' => $path,
        ]);

        return redirect()->route('fornecedores.login')->with('success', 'Cadastro enviado para análise.');
    }

    #[OA\Post(path: "/fornecedores/login", summary: "Realiza o login do fornecedor", tags: ["Fornecedores"])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email", "password"],
            properties: [
                new OA\Property(property: "email", type: "string", format: "email"),
                new OA\Property(property: "password", type: "string", format: "password"),
            ]
        )
    )]
    #[OA\Response(response: 302, description: "Redireciona para o dashboard do fornecedor")]
    #[OA\Response(response: 401, description: "Credenciais inválidas")]
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::guard('fornecedores')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('fornecedores.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('fornecedores')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('fornecedores.login')->with('success', 'Você saiu do sistema.');
    }

    public function listarPendentes()
    {
        $pendentes = FornecedorPendente::all();
        return view('admin.verifyfornecedor', compact('pendentes'));
    }

    public function aprovar($id)
    {
        $pendente = FornecedorPendente::findOrFail($id);

        Fornecedor::create([
            'nome_empresa' => $pendente->nome_empresa,
            'cnpj' => $pendente->cnpj,
            'email' => $pendente->email,
            'telefone' => $pendente->telefone,
            'password' => Hash::make($pendente->password),
            'foto' => $pendente->foto,
        ]);

        $this->novuService->sendFornecedorAprovado(
            subscriberId: 'fornecedor_' . $pendente->id,
            email: $pendente->email,
            fornecedorName: $pendente->nome_empresa
        );

        $pendente->delete();

        return redirect()->route('fornecedores.pendentes')->with('success', 'Fornecedor aprovado!');
    }

    public function rejeitar($id)
    {
        $pendente = FornecedorPendente::findOrFail($id);

        $this->novuService->sendFornecedorRejeitado(
            subscriberId: 'fornecedor_' . $pendente->id,
            email: $pendente->email,
            fornecedorName: $pendente->nome_empresa
        );

        if ($pendente->foto) {
            Storage::disk('public')->delete($pendente->foto);
        }

        $pendente->delete();

        return redirect()->route('fornecedores.pendentes')->with('success', 'Fornecedor rejeitado!');
    }

    public function dashboard()
    {
        $fornecedor = Auth::guard('fornecedores')->user();
        return view('fornecedores.dashboard', compact('fornecedor'));
    }

    public function vendasSemana()
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $hoje = now()->endOfDay();
        $seteDiasAtras = now()->subDays(6)->startOfDay();

        $vendas = DB::table('venda_lancamentos')
            ->select(DB::raw('DATE(lancado_em) as dia'), DB::raw('SUM(quantidade) as total'))
            ->where('fornecedor_id', $fornecedor->id_fornecedores)
            ->whereBetween('lancado_em', [$seteDiasAtras, $hoje])
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->keyBy('dia');

        $labels = [];
        $totais = [];

        for ($i = 0; $i < 7; $i++) {
            $dia = $seteDiasAtras->copy()->addDays($i)->format('Y-m-d');
            $labels[] = $dia;
            $totais[] = $vendas->has($dia) ? (int)$vendas[$dia]->total : 0;
        }

        return response()->json([
            'labels' => $labels,
            'totais' => $totais,
        ]);
    }

    public function faturamentoSemana()
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $hoje = now()->endOfDay();
        $seteDiasAtras = now()->subDays(6)->startOfDay();

        $faturamento = DB::table('venda_lancamentos')
            ->select(DB::raw('DATE(lancado_em) as dia'), DB::raw('SUM(subtotal) as total'))
            ->where('fornecedor_id', $fornecedor->id_fornecedores)
            ->whereBetween('lancado_em', [$seteDiasAtras, $hoje])
            ->groupBy('dia')
            ->orderBy('dia')
            ->get()
            ->keyBy('dia');

        $labels = [];
        $totais = [];

        for ($i = 0; $i < 7; $i++) {
            $dia = $seteDiasAtras->copy()->addDays($i)->format('Y-m-d');
            $labels[] = $dia;
            $totais[] = $faturamento->has($dia) ? (float)$faturamento[$dia]->total : 0;
        }

        return response()->json([
            'labels' => $labels,
            'totais' => $totais,
        ]);
    }

    public function produtosMaisVendidos()
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $seteDiasAtras = now()->subDays(6)->startOfDay();
        $hoje = now()->endOfDay();

        $produtosVendidos = DB::table('venda_lancamentos')
            ->join('produtos_fornecedores', 'venda_lancamentos.produto_id', '=', 'produtos_fornecedores.id_produtos')
            ->select('produtos_fornecedores.nome', DB::raw('SUM(venda_lancamentos.quantidade) as total_vendido'))
            ->where('venda_lancamentos.fornecedor_id', $fornecedor->id_fornecedores)
            ->whereBetween('venda_lancamentos.lancado_em', [$seteDiasAtras, $hoje])
            ->groupBy('produtos_fornecedores.nome')
            ->orderByDesc('total_vendido')
            ->limit(10)
            ->get();

        return response()->json([
            'labels' => $produtosVendidos->pluck('nome'),
            'totais' => $produtosVendidos->pluck('total_vendido'),
        ]);
    }

    public function estoqueBaixo()
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $estoque = DB::table('produto_estoques')
            ->join('produtos_fornecedores', 'produto_estoques.produto_id', '=', 'produtos_fornecedores.id_produtos')
            ->select('produtos_fornecedores.nome', DB::raw('SUM(produto_estoques.quantidade) as total'))
            ->where('produtos_fornecedores.id_fornecedores', $fornecedor->id_fornecedores)
            ->groupBy('produtos_fornecedores.nome')
            ->orderBy('total')
            ->limit(10)
            ->get();

        return response()->json([
            'labels' => $estoque->pluck('nome'),
            'totais' => $estoque->pluck('total'),
        ]);
    }

    // --- Toggle Produto ---
    public function toggleProduto($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);

        // Alterna ativo
        $produto->ativo = !$produto->ativo;
        $produto->save();

        $status = $produto->ativo ? 'ATIVO' : 'INATIVO';

        // Retorna JSON para não recarregar a página
        return response()->json([
            'success' => true,
            'message' => "Produto atualizado para {$status} com sucesso!",
            'produto_id' => $produto->id_produtos,
            'ativo' => $produto->ativo
        ]);
    }

    // --- Excluir Produto ---
    public function destroyProduto($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);

        if ($produto->foto) {
            Storage::disk('public')->delete($produto->foto);
        }

        $produto->delete();

        return response()->json([
            'success' => true,
            'message' => "Produto excluído com sucesso!",
            'produto_id' => $id
        ]);
    }
    
   public function mostrarEmpresa($id)
{
    $fornecedor = Fornecedor::findOrFail($id);

    // Produtos do fornecedor
    $produtos = ProdutoFornecedor::where('id_fornecedores', $fornecedor->id_fornecedores)
        ->orderBy('id_produtos', 'desc')
        ->get();

    // IDs dos produtos
    $idsProdutos = $produtos->pluck('id_produtos');

    // IDs dos produtos que o usuário colocou na lista de desejos
$idsDesejados = \DB::table('lista_desejos')
    ->where('id_usuarios', auth()->id())
    ->pluck('id_produtos')
    ->toArray();

    // Média de avaliações do fornecedor
    $mediaAvaliacoes = \DB::table('avaliacoes')
        ->whereIn('id_produtos', $idsProdutos)
        ->avg('nota') ?? 0;

    // Total de avaliações
    $totalAvaliacoes = \DB::table('avaliacoes')
        ->whereIn('id_produtos', $idsProdutos)
        ->count();

    // Média de cada produto (para o card)
    $mediasProdutos = \DB::table('avaliacoes')
        ->select('id_produtos', \DB::raw('AVG(nota) as media'))
        ->whereIn('id_produtos', $idsProdutos)
        ->groupBy('id_produtos')
        ->pluck('media', 'id_produtos');

    $totalProdutos = $produtos->count();
    $totalVendidos = DB::table('venda_lancamentos')
        ->where('fornecedor_id', $fornecedor->id_fornecedores)
        ->sum('quantidade');

    return view('usuarios.mostrar', compact(
        'fornecedor',
        'produtos',
        'mediaAvaliacoes',
        'totalAvaliacoes',
        'totalProdutos',
        'totalVendidos',
        'mediasProdutos',
        'idsDesejados'
    ));
}



}