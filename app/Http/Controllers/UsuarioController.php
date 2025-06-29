<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'sexo'            => 'required|string',
            'nome_completo'   => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'email'           => 'required|email|unique:usuarios,email',
            'password'        => 'required|string|min:6',
            'telefone'        => 'required|string',
            'cpf'             => ['required', 'regex:/^\d{11}$/', 'unique:usuarios,cpf'],
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'cpf.regex'    => 'O CPF deve conter exatamente 11 dígitos numéricos.',
        ]);

        // Normaliza sexo para M ou F
        if (isset($dados['sexo'])) {
            $sexo         = strtolower($dados['sexo']);
            $dados['sexo'] = $sexo === 'masculino' ? 'M' : ($sexo === 'feminino' ? 'F' : null);
            if (!$dados['sexo']) {
                return back()->withErrors(['sexo' => 'Sexo inválido.'])->withInput();
            }
        }

        $dados['password'] = Hash::make($dados['password']);

        if ($request->hasFile('foto')) {
            $dados['foto'] = $request->file('foto')->store('fotos_usuario_final', 'public');
        }

        Usuario::create($dados);

        return redirect()->route('login.form')->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
    }

    public function showLoginForm(Request $request)
    {
        if (Auth::guard('usuarios')->check()) {
            return redirect()->back()->withErrors([
                'login_ja_autenticado' => 'Você já está logado. Faça logout se quiser acessar a tela de login.'
            ]);
        }

        return view('usuarios.login');
    }

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('usuarios')->attempt($dados)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['login' => 'Credenciais inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('usuarios')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Você saiu do sistema.');
    }

    public function dashboard()
    {
        if (!Auth::guard('usuarios')->check()) {
            return redirect()->route('login.form')->withErrors(['acesso' => 'Faça login para acessar o sistema.']);
        }

        $usuario = Auth::guard('usuarios')->user();
        $nome    = $usuario->nome_completo;

        return view('usuarios.dashboard', compact('nome'));
    }

    public function update(Request $request)
    {
        $usuario = Auth::guard('usuarios')->user();

        $dados = $request->validate([
            'nome_completo' => 'required|string|max:50',
        ]);

        $usuario->update($dados);

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    public function edit()
    {
        $usuario = Auth::guard('usuarios')->user();
        return view('usuarios.partials.perfil', compact('usuario'));
    }

    public function painel()
    {
        $usuario   = Auth::guard('usuarios')->user();
        $enderecos = $usuario->enderecos; // Relacionamento já deve existir no model
        return view('usuarios.perfil', compact('usuario', 'enderecos'));
    }
}