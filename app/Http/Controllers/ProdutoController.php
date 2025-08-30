<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;

class ProdutoController extends Controller
{

    
public function buscar(Request $request)
{
    $query = trim($request->input('q'));

    // Se não digitar nada, retorna todos
    if ($query === '') {
        $produtos = ProdutoFornecedor::limit(20)->get();
    } else {
        $produtos = ProdutoFornecedor::where('nome', 'LIKE', "%{$query}%")
            ->limit(20)
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
    ->latest() // ou algum critério de recomendação
    ->limit(4)
    ->get();


    return view('usuarios.detalhes-produto', [
        'produto' => $produto,
        'produtos' => $produtosRecomendados,
    ]);
}





}

