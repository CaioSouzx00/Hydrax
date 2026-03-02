<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;
use App\Models\ProdutoImagemRotulo;

class ProdutoImagemRotuloController extends Controller
{
    public function create($id)
    {
        $produto = ProdutoFornecedor::with('fornecedor')->findOrFail($id);

        // Pega o nome do fornecedor logado
        $fornecedorNome = $produto->fornecedor->nome_empresa ?? 'Desconhecido';

        return view('fornecedores.produtos.rotulos.create', compact('produto', 'fornecedorNome'));
    }

    public function store(Request $request, $id)
    {
        // Validação básica
        $request->validate([
            'imagem' => 'required|string',
            'categoria' => 'required|string',
            'estilo' => 'required|string',
            'genero' => 'required|string',
        ]);

        // Recupera o produto
        $produto = ProdutoFornecedor::with('fornecedor')->findOrFail($id);

        // Verifica duplicidade
        $exists = ProdutoImagemRotulo::where('id_produto', $produto->id_produtos)
            ->where('categoria', $request->categoria)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Essa label já foi cadastrada para este produto.');
        }

        // Prepara os dados para inserir
        $dados = [
            'id_produto' => $produto->id_produtos, // FK correta
            'imagem' => $request->imagem,
            'categoria' => $request->categoria,
            'estilo' => $request->estilo,
            'genero' => $request->genero,
            'marca' => $produto->fornecedor->nome_empresa ?? 'Desconhecido',
        ];

        // Cria o rótulo
        ProdutoImagemRotulo::create($dados);

        return redirect()
            ->route('fornecedores.produtos.index')
            ->with('success', 'Rótulo do produto cadastrado com sucesso!');
    }
}
