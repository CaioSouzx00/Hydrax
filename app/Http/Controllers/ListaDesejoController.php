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

    $desejos = ListaDesejo::with('produto')
        ->where('id_usuarios', $idUsuario)
        ->get();

    return view('usuarios.lista-desejos', compact('desejos'));
}


public function store($id_produtos)
{
    $idUsuario = Auth::guard('usuarios')->id();

    ListaDesejo::firstOrCreate([
        'id_usuarios' => $idUsuario,
        'id_produtos' => $id_produtos,
    ]);

    return back()->with('success', 'Produto adicionado à lista de desejos!');
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
