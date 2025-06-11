<?php

namespace App\Http\Controllers;

use App\Models\FornecedorPendente;
//use App\Models\Fornecedor;
use Illuminate\Http\Request;


class FornecedorController extends Controller
{

    public function showLoginForm()
{
    return view('fornecedores.login');
}

public function create()
    {
        return view('fornecedores.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'nome_empresa' => 'required|string|max:255',
        'cnpj' => 'required|string|max:20|unique:fornecedores_pendentes,cnpj',
        'email' => 'required|email|unique:fornecedores_pendentes,email',
        'telefone' => 'required|string|max:20',
        'senha' => 'required|string|min:6|confirmed',
    ]);

    FornecedorPendente::create([
        'nome_empresa' => $validated['nome_empresa'],
        'cnpj' => $validated['cnpj'],
        'email' => $validated['email'],
        'telefone' => $validated['telefone'],
        'senha' => $validated['senha'], // passará pelo mutator
        'status' => 'pendente',
    ]);

    return redirect()->route('fornecedores.login')->with('success', 'Cadastro enviado para análise.');
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
        'senha' => $pendente->senha,
    ]);

    $pendente->delete();

    return redirect()->route('fornecedores.pendentes')->with('success', 'Fornecedor aprovado!');
}

public function rejeitar($id)
{
    $pendente = FornecedorPendente::findOrFail($id);
    $pendente->delete();

    return redirect()->route('fornecedores.pendentes')->with('success', 'Fornecedor rejeitado!');
}

}