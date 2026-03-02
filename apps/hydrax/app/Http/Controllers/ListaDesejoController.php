<?php

namespace App\Http\Controllers;

use App\Models\ListaDesejo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaDesejoController extends Controller
{
public function index()
{
    $idUsuario = Auth::guard('usuarios')->id();

    $desejos = ListaDesejo::with(['produto' => function($query) {
        $query->with('fornecedor')        // fornecedor do produto
              ->with('avaliacoes')        // todas as avaliações
              ->withAvg('avaliacoes', 'nota'); // média das notas
    }])
    ->where('id_usuarios', $idUsuario)
    ->get();

    return view('usuarios.lista-desejos', compact('desejos'));
}


public function store($id_produtos, Request $request)
{
    $idUsuario = Auth::guard('usuarios')->id();

    $item = ListaDesejo::where('id_usuarios', $idUsuario)
        ->where('id_produtos', $id_produtos)
        ->first();

    if ($item) {
        $item->delete();
        $action = 'removido';
    } else {
        ListaDesejo::create([
            'id_usuarios' => $idUsuario,
            'id_produtos' => $id_produtos,
        ]);
        $action = 'adicionado';
    }

    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'action' => $action,
        ]);
    }

   //return back()->with('success', "Produto {$action} da lista de desejos!");
    return redirect()->to(url()->previous() . '#catalago')
    ->with('success', "Produto {$action} da lista de desejos!");

}

public function show($id)
{
    $produto = ProdutoFornecedor::with('fornecedor', 'avaliacoes')->findOrFail($id);

    $idUsuario = Auth::guard('usuarios')->id();
    
    $estaNaLista = false;

    if ($idUsuario) {
        $isDesejado = ListaDesejo::where('id_usuarios', $idUsuario)
                ->where('id_produtos', $produto->id_produtos)
                ->exists();

    }

    // aqui você já manda o flag pra view
    return view('usuarios.produtos.show', compact('produto', 'estaNaLista', 'isDesejado'));
}


public function destroy($id_produtos)
{
    $idUsuario = Auth::guard('usuarios')->id();

    ListaDesejo::where('id_usuarios', $idUsuario)
        ->where('id_produtos', $id_produtos)
        ->delete();

    return back()->with('success', 'Produto removido da lista de desejos!');
}

}
