<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProdutoFornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdutoFornecedorController extends Controller
{
    public function create()
    {
        return view('fornecedores.produtos.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'descricao' => 'nullable|string',
        'preco' => 'required|numeric',
        'estoque_imagem' => 'nullable|string',
        'caracteristicas' => 'nullable|string',
        'historico_modelos' => 'nullable|string',
        'tamanhos_disponiveis' => 'nullable|string',
        'genero' => 'nullable|string',
        'categoria' => 'nullable|string',
        'fotos' => 'nullable|string',
        'ativo' => 'required|boolean',
    ]);

    $dados = $request->all();
    $dados['slug'] = Str::slug($request->nome);
    $dados['id_fornecedores'] = auth()->user()->id;

    ProdutoFornecedor::create($dados);

    return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
}

}