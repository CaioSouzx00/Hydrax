<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        'senha' => 'required|string|min:6',
        'telefone' => 'required|string',
        'cpf' => ['required', 'regex:/^\d{11}$/', 'unique:usuarios,cpf'],
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'senha.min' => 'A senha deve ter no mínimo 6 caracteres.',
        'cpf.regex' => 'O CPF deve conter exatamente 11 dígitos numéricos.',
    ]);

    // Converter sexo de texto para 'M' ou 'F'
    if (isset($dados['sexo'])) {
        $sexo = strtolower($dados['sexo']);
        if ($sexo === 'masculino') {
            $dados['sexo'] = 'M';
        } elseif ($sexo === 'feminino') {
            $dados['sexo'] = 'F';
        } else {
            return back()->withErrors(['sexo' => 'Sexo inválido.'])->withInput();
        }
    }

    $dados['senha'] = Hash::make($dados['senha']);

    if ($request->hasFile('foto')) {
        $dados['foto'] = $request->file('foto')->store('fotos_usuario_final', 'public');
    }

    Usuario::create($dados);

    return redirect()->route('login.form')->with('success', 'Cadastro realizado com sucesso! Faça login para continuar.');
}

public function showLoginForm()
{
    return view('usuarios.login'); // View de login: usuarios/login.blade.php
}

// Método para processar o login
public function login(Request $request)
{
    $dados = $request->validate([
        'email' => 'required|email',
        'senha' => 'required',
    ]);

    $usuario = Usuario::where('email', $dados['email'])->first();

    if ($usuario && Hash::check($dados['senha'], $usuario->senha)) {
        // Regenera o ID da sessão ao fazer login para evitar ataques de fixação de sessão
        session()->regenerate();

        session([
            'usuario_id' => $usuario->id,
            'usuario_nome' => $usuario->nome_completo,
        ]);

        return redirect()->route('dashboard'); // Defina a rota para onde enviar após login
    }

    return back()->withErrors(['login' => 'Credenciais inválidas'])->withInput();
}


    // Método para logout
    public function logout()
    {
        session()->flush(); // Limpa todos os dados da sessão
        return redirect()->route('login.form')->with('success', 'Você saiu do sistema.');
    }
}
