<?php

namespace App\Http\Controllers;

use App\Http\Requests\Fornecedor\StoreFornecedorRequest;
use App\Models\FornecedorPendente;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\FornecedorAprovadoMail;
use App\Mail\FornecedorRejeitadoMail;
use App\Models\ProdutoFornecedor;
use App\Models\Avaliacao;

/**
 * Controller responsável pelas operações relacionadas a fornecedores.
 * 
 * Refatorado seguindo Clean Code e SOLID:
 * - Validações movidas para Form Requests
 * - Controller mantém apenas orquestração e respostas HTTP
 */
class FornecedorController extends Controller
{
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

    /**
     * Armazena um novo fornecedor pendente.
     * 
     * Validação via StoreFornecedorRequest.
     *
     * @param StoreFornecedorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        Mail::to($pendente->email)->send(new FornecedorAprovadoMail($pendente));

        $pendente->delete();

        return redirect()->route('fornecedores.pendentes')->with('success', 'Fornecedor aprovado!');
    }

    public function rejeitar($id)
    {
        $pendente = FornecedorPendente::findOrFail($id);

        Mail::to($pendente->email)->send(new FornecedorRejeitadoMail($pendente));

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
    $totalVendidos = $produtos->sum('vendidos');

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