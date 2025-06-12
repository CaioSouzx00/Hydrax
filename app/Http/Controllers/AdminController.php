<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Administrador;

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

}
