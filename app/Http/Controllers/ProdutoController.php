<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;

class ProdutoController extends Controller
{
  public function buscar(Request $request)
{
    $query = $request->input('q');

    if (!$query) {
        // Quando o campo estiver vazio, retorna todos os produtos
        $produtos = ProdutoFornecedor::limit(20)->get();

        $html = $produtos->map(function ($produto) {
            return view('usuarios.partials.card-produto', compact('produto'))->render();
        })->implode('');

        return response()->json(['html' => $html]);
    }

    if (strlen($query) < 2) {
        return response()->json([
            'html' => '<p class="text-white p-6 pt-24">Digite 2 ou mais caracteres para buscar.</p>'
        ]);
    }

    $produtos = ProdutoFornecedor::where('nome', 'LIKE', "%{$query}%")->limit(20)->get();

    if ($produtos->isEmpty()) {
        return response()->json([
            'html' => '<p class="text-white p-6 pt-24">Nenhum produto encontrado para: ' . e($query) . '</p>'
        ]);
    }

    $html = $produtos->map(function ($produto) {
        return view('usuarios.partials.card-produto', compact('produto'))->render();
    })->implode('');

    return response()->json(['html' => $html]);
}


public function detalhes($id)
{
    $produto = ProdutoFornecedor::findOrFail($id);
    return view('usuarios.partials.detalhes-produto', compact('produto'));
}



}

