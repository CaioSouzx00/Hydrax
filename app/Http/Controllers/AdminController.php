<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Administrador;
use App\Models\ProdutoFornecedor;
use App\Models\Usuario;

class AdminController extends Controller
{
    // Mostrar formulário de cadastro do administrador
    public function create()
    {
        return view('admin.create'); // View do formulário de cadastro
    }

    // Armazenar novo administrador
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome_usuario' => 'required|string|max:50|unique:administradores,nome_usuario',
            'password' => 'required|string|min:6',
        ], [
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ]);

        $dados['password'] = Hash::make($dados['password']);

        Administrador::create($dados);

        return redirect()->route('admin.dashboard')->with('success', 'Administrador cadastrado com sucesso!');
    }

    // Mostrar formulário de login
    public function showLoginForm()
    {
        return view('admin.login');
    }

public function login(Request $request)
{
    $credentials = $request->only('nome_usuario', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate(); // <- ESSENCIAL
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors([
        'nome_usuario' => 'Credenciais inválidas.',
    ])->withInput();
}

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Você saiu do sistema.');
    }

    // Mostra o dashboard
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login')->withErrors(['acesso' => 'Faça login para acessar o painel.']);
        }

        return view('admin.dashboard', compact('admin'));
    }

      public function dadosGraficos()
{
    $anoAtual = date('Y');

    // Usuários por mês no ano atual e created_at não nulo
    $usuariosPorMes = DB::table('usuarios')
        ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('count(*) as total'))
        ->whereNotNull('created_at')
        ->whereYear('created_at', $anoAtual)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'mes');

    // Fornecedores por mês no ano atual e created_at não nulo
    $fornecedoresPorMes = DB::table('fornecedores')
        ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('count(*) as total'))
        ->whereNotNull('created_at')
        ->whereYear('created_at', $anoAtual)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'mes');

    $labels = range(1, 12);

    // Preencher meses sem dados com zero 
    $usuarios = array_map(function ($mes) use ($usuariosPorMes) {
        return $usuariosPorMes->get($mes, 0);
    }, $labels);

    $fornecedores = array_map(function ($mes) use ($fornecedoresPorMes) {
        return $fornecedoresPorMes->get($mes, 0);
    }, $labels);

    return response()->json([
        'labels' => $labels,
        'usuarios' => $usuarios,
        'fornecedores' => $fornecedores,
    ]);
}

public function dadosProdutos()
{
    $anoAtual = date('Y');

    $produtosPorMes = DB::table('produtos_fornecedores')
        ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('count(*) as total'))
        ->whereNotNull('created_at')
        ->whereYear('created_at', $anoAtual)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'mes');

    $labels = range(1, 12);

    $produtos = array_map(function ($mes) use ($produtosPorMes) {
        return $produtosPorMes->get($mes, 0);
    }, $labels);

    return response()->json([
        'labels' => $labels,
        'produtos' => $produtos,
    ]);
}

public function vendasSemana()
{
    // Datas: 6 dias atrás até hoje (7 dias no total)
    $hoje = now()->endOfDay();
    $seteDiasAtras = now()->subDays(6)->startOfDay();

    // Consulta carrinhos finalizados por dia
    $vendas = \DB::table('carrinhos')
        ->select(\DB::raw('DATE(created_at) as dia'), \DB::raw('COUNT(*) as total'))
        ->where('status', 'finalizado') // só carrinhos finalizados
        ->whereBetween('created_at', [$seteDiasAtras, $hoje])
        ->groupBy('dia')
        ->orderBy('dia')
        ->get();

    // Arrays para labels e valores
    $labels = [];
    $totais = [];

    // Preenche todos os dias, mesmo sem vendas
    for($i = 0; $i < 7; $i++){
        $dia = $seteDiasAtras->copy()->addDays($i)->format('Y-m-d');
        $labels[] = $dia;
        $totais[] = $vendas->firstWhere('dia', $dia)->total ?? 0;
    }

    return response()->json([
        'labels' => $labels,
        'totais' => $totais,
    ]);
}

public function faturamentoSemana()
{
    $hoje = now()->endOfDay();
    $seteDiasAtras = now()->subDays(6)->startOfDay();

    $faturamento = \DB::table('carrinhos')
        ->join('carrinho_itens', 'carrinhos.id', '=', 'carrinho_itens.carrinho_id')
        ->join('produtos_fornecedores', 'carrinho_itens.produto_id', '=', 'produtos_fornecedores.id_produtos')

        ->select(
            \DB::raw('DATE(carrinhos.created_at) as dia'),
            \DB::raw('SUM(produtos_fornecedores.preco * carrinho_itens.quantidade) as total')
        )
        ->where('carrinhos.status', 'finalizado')
        ->whereBetween('carrinhos.created_at', [$seteDiasAtras, $hoje])
        ->groupBy('dia')
        ->orderBy('dia')
        ->get()
        ->keyBy('dia');

    $labels = [];
    $totais = [];

    for ($i = 0; $i < 7; $i++) {
        $dia = $seteDiasAtras->copy()->addDays($i)->format('Y-m-d');
        $labels[] = $dia;
        $totais[] = $faturamento->has($dia) ? $faturamento[$dia]->total : 0;
    }

    return response()->json([
        'labels' => $labels,
        'totais' => $totais,
    ]);
}


public function produtosMaisVendidos()
{
    $seteDiasAtras = now()->subDays(6)->startOfDay();
    $hoje = now()->endOfDay();

    // Consulta produtos vendidos nos carrinhos finalizados
    $produtosVendidos = \DB::table('carrinhos')
        ->join('carrinho_itens', 'carrinhos.id', '=', 'carrinho_itens.carrinho_id')
        ->join('produtos_fornecedores', 'carrinho_itens.produto_id', '=', 'produtos_fornecedores.id_produtos')
        ->select('produtos_fornecedores.nome', \DB::raw('SUM(carrinho_itens.quantidade) as total_vendido'))
        ->where('carrinhos.status', 'finalizado')
        ->whereBetween('carrinhos.created_at', [$seteDiasAtras, $hoje])
        ->groupBy('produtos_fornecedores.nome')
        ->orderByDesc('total_vendido')
        ->limit(10) // Top 10 produtos
        ->get();

    $labels = $produtosVendidos->pluck('nome');
    $totais = $produtosVendidos->pluck('total_vendido');

    return response()->json([
        'labels' => $labels,
        'totais' => $totais,
    ]);
}

 // Listagem de produtos
    public function listarProdutos()
    {
        // Pega todos os produtos com dados do fornecedor
        $produtos = ProdutoFornecedor::with('fornecedor')->paginate(10);

        return view('admin.listagem', compact('produtos'));
    }

    // Ativar / Desativar produto
    public function toggleProduto($id)
    {
        $produto = ProdutoFornecedor::findOrFail($id);
        $produto->ativo = !$produto->ativo;
        $produto->save();

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

     // Listagem de clientes
    public function listarClientes() {
        $usuarios = Usuario::paginate(12); // Paginação de 12 por página
        return view('admin.listagem-clientes', compact('usuarios'));
    }

    // Histórico de compras do usuário
    public function historicoCompras($id) {
        $usuario = Usuario::findOrFail($id);
        $pedidos = $usuario->carrinhos()->with('itens.produto')->get();
        return view('admin.historico-compra', compact('usuario','pedidos'));
    }

    // Listagem de fornecedores
public function listarFornecedores()
{
    $fornecedores = \App\Models\Fornecedor::paginate(12); // ou ajusta a paginação
    return view('admin.listagem-fornecedores', compact('fornecedores'));
}

// Histórico de produtos de um fornecedor
public function historicoProdutos($id)
{
    $fornecedor = \App\Models\Fornecedor::findOrFail($id);
    $produtos = $fornecedor->produtos()->get(); // assumindo relacionamento no model
    return view('admin.historico-produtos', compact('fornecedor','produtos'));
}

}
