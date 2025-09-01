<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;

class ProdutoController extends Controller
{

    
public function buscar(Request $request)
{
    $query = trim($request->input('q'));
    $genero = $request->input('genero');
    $categoria = $request->input('categoria');
    $tamanho = $request->input('tamanho');
    $preco_min = $request->input('preco_min');
    $preco_max = $request->input('preco_max');

    $produtos = ProdutoFornecedor::ativos();

    if ($query !== '') {
        $produtos->where(function ($q) use ($query) {
            $q->where('nome', 'LIKE', "%{$query}%")
              ->orWhere('descricao', 'LIKE', "%{$query}%");
        });
    }

    if (!empty($genero)) {
        $produtos->where('genero', $genero);
    }

    if (!empty($categoria)) {
        $produtos->where('categoria', $categoria);
    }

    if (!empty($tamanho)) {
        $produtos->whereJsonContains('tamanhos_disponiveis', (int)$tamanho);
    }

    if (!empty($preco_min)) {
        $produtos->where('preco', '>=', $preco_min);
    }

    if (!empty($preco_max)) {
        $produtos->where('preco', '<=', $preco_max);
    }

    $produtos = $produtos->paginate(21)->withQueryString();

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

