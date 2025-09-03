<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;
use Illuminate\Pagination\LengthAwarePaginator;

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

    $produtosQuery = ProdutoFornecedor::ativos();

    if ($query !== '') {
        $produtosQuery->where(function ($q) use ($query) {
            $q->where('nome', 'LIKE', "%{$query}%")
              ->orWhere('descricao', 'LIKE', "%{$query}%");
        });
    }

    if (!empty($genero)) $produtosQuery->where('genero', $genero);
    if (!empty($categoria)) $produtosQuery->where('categoria', $categoria);
    if (!empty($tamanho)) {
    $produtosQuery->whereJsonContains('tamanhos_disponiveis', (string)$tamanho);
}

    if (!empty($preco_min)) $produtosQuery->where('preco', '>=', $preco_min);
    if (!empty($preco_max)) $produtosQuery->where('preco', '<=', $preco_max);

    $produtos = $produtosQuery->paginate(21)->withQueryString();

    // Renderiza cada produto corretamente
    if ($produtos->isEmpty()) {
        $html = '<p class="text-white p-6 pt-24">Nenhum produto encontrado.</p>';
    } else {
        $html = $produtos->map(function($produto) {
            // Normaliza JSON das fotos
            $produto->fotos = json_decode($produto->fotos, true) ?: [];

            return view('usuarios.partials.card-produto', compact('produto'))->render();
        })->implode('');
    }

    $pagination = view('vendor.pagination.custom', ['paginator' => $produtos])->render();
    
    $texto = "Mostrando {$produtos->firstItem()} a {$produtos->lastItem()} de {$produtos->total()} resultados";

    return response()->json([
        'html' => $html,
        'pagination' => $pagination,
        'texto' => $texto
    ]);
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

