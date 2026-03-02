<?php

namespace App\Http\Controllers;

use App\Models\ProdutoFornecedor;
use App\Models\ProdutoEstoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoEstoqueController extends Controller
{
    public function edit($produtoId)
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $produto = ProdutoFornecedor::where('id_fornecedores', $fornecedor->id_fornecedores)
            ->findOrFail($produtoId);

        $tamanhos = is_array($produto->tamanhos_disponiveis) ? $produto->tamanhos_disponiveis : [];

        $estoques = ProdutoEstoque::where('produto_id', $produto->id_produtos)
            ->get()
            ->keyBy('tamanho');

        return view('fornecedores.produtos.partials.estoque', compact('produto', 'tamanhos', 'estoques'));
    }

    public function update(Request $request, $produtoId)
    {
        $fornecedor = Auth::guard('fornecedores')->user();

        $produto = ProdutoFornecedor::where('id_fornecedores', $fornecedor->id_fornecedores)
            ->findOrFail($produtoId);

        $tamanhos = is_array($produto->tamanhos_disponiveis) ? $produto->tamanhos_disponiveis : [];

        $data = $request->validate([
            'estoque' => 'required|array',
        ]);

        foreach ($tamanhos as $tamanho) {
            $qtd = $data['estoque'][$tamanho] ?? 0;
            $qtd = is_numeric($qtd) ? (int)$qtd : 0;
            if ($qtd < 0) {
                $qtd = 0;
            }

            ProdutoEstoque::updateOrCreate(
                ['produto_id' => $produto->id_produtos, 'tamanho' => (string)$tamanho],
                ['quantidade' => $qtd]
            );
        }

        return redirect()->route('fornecedores.produtos.index')->with('success', 'Estoque atualizado com sucesso!');
    }
}
