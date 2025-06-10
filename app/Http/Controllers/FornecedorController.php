<?php

namespace App\Http\Controllers;

use App\Models\FornecedorPendente;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{

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