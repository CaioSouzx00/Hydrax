<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdutoFornecedor;

class ProdutoController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $produtos = ProdutoFornecedor::where('descricao', 'LIKE', "%{$query}%")
              ->limit(10)
              ->get(['id_produtos', 'descricao']);


        return response()->json($produtos);
    }
}

