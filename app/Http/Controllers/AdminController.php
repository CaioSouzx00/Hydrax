<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    // Realiza o login 
    /*public function login(Request $request)
    {
        $credentials = $request->validate([
            'nome_usuario' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'nome_usuario' => 'Usuário ou senha inválidos.',
        ])->withInput();
    }*/


public function login(Request $request)
{
    $credentials = $request->only('nome_usuario', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
        return redirect()->route('admin.dashboard');
    }

    // Falha no login
    return back()->withErrors([
        'nome_usuario' => 'Credenciais inválidas.',
    ])->withInput();
}

    // Faz logout
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
}
