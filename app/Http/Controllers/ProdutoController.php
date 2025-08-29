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
    $produto = ProdutoFornecedor::with('fornecedor')->findOrFail($id);
    return view('usuarios.detalhes-produto', compact('produto'));
}



}

