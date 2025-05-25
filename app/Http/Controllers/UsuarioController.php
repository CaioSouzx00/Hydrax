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
            'sexo' => 'required|string',
            'nome_completo' => 'required|string|max:50',
            'data_nascimento' => 'required|date',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'telefone' => 'required|string',
            'cpf' => ['required', 'regex:/^\d{11}$/', 'unique:usuarios,cpf'],
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'cpf.regex' => 'O CPF deve conter exatamente 11 dígitos numéricos.',
        ]);

        if (isset($dados['sexo'])) {
            $sexo = strtolower($dados['sexo']);
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

    public function showLoginForm()
    {
        return view('usuarios.login');
    }

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $dados['email'], 'password' => $dados['password']])) {
            $request->session()->regenerate();

            // Salvar dados do usuário na sessão
            $usuario = Auth::user();
            session([
                'usuario_id' => $usuario->id_usuarios,
                'usuario_nome' => $usuario->nome_completo,
            ]);

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['login' => 'Credenciais inválidas'])->withInput();
    }

    public function logout()
    {
        session()->flush(); // limpa tudo
        Auth::logout();
        return redirect()->route('login.form')->with('success', 'Você saiu do sistema.');
    }

    public function dashboard()
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login.form')->withErrors(['acesso' => 'Faça login para acessar o sistema.']);
        }

        $nome = session('usuario_nome');
        return view('usuarios.dashboard', compact('nome'));
    }
}