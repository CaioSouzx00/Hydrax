<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;

class ProdutoController extends Controller
{

    
public function buscar(Request $request)
{
    $query = trim($request->input('q'));

    if ($query === '') {
        // Retorna apenas produtos ativos
        $produtos = ProdutoFornecedor::ativos()
            ->limit(48)
            ->get();
    } else {
        // Retorna apenas produtos ativos que batem com a busca
        $produtos = ProdutoFornecedor::ativos()
            ->where('nome', 'LIKE', "%{$query}%")
            ->limit(48)
            ->get();
    }

    $html = $produtos->map(function ($produto) {
        return view('usuarios.partials.card-produto', compact('produto'))->render();
    })->implode('');

    if ($produtos->isEmpty()) {
        $html = '<p class="text-white p-6 pt-24">Nenhum produto encontrado.</p>';
    }

    return response()->json(['html' => $html]);
}


public function detalhes($id)
{
    $usuario = auth()->guard('usuarios')->user(); // pega usuário logado
    $produto = ProdutoFornecedor::with('fornecedor')->findOrFail($id);

    // Pegar produtos do carrinho do usuário (exceto o produto atual)
    $carrinho = $usuario->carrinhoAtivo;

    $produtosRecomendados = ProdutoFornecedor::where('id_produtos', '!=', $id)
        ->inRandomOrder()
        ->limit(4)
        ->get();

    return view('usuarios.detalhes-produto', [
        'produto' => $produto,
        'produtos' => $produtosRecomendados,
    ]);
}






}

