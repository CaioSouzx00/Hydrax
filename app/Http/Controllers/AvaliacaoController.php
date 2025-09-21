<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
  // Mostra a tela de avaliação
    public function create($id_produto)
    {
        return view('usuarios.avaliacoes.create', compact('id_produto'));
    }

    // Salva a avaliação
   public function store(Request $request, $id_produto)
    {
        $idUsuario = Auth::guard('usuarios')->id();

        $request->validate([
            'nota' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
            'conforto' => 'required|integer|min:1|max:5', // Adicionado
            'qualidade' => 'required|integer|min:1|max:5', // Adicionado
            'tamanho' => 'required|integer|min:1|max:5', // Adicionado
            'largura' => 'required|integer|min:1|max:5', // Adicionado
        ]);

        if (Avaliacao::where('id_usuarios', $idUsuario)->where('id_produtos', $id_produto)->exists()) {
            return back()->with('error', 'Você já avaliou este produto.');
        }

        Avaliacao::create([
            'id_usuarios' => $idUsuario,
            'id_produtos' => $id_produto,
            'nota' => $request->nota,
            'comentario' => $request->comentario,
            'conforto' => $request->conforto, // Adicionado
            'qualidade' => $request->qualidade, // Adicionado
            'tamanho' => $request->tamanho, // Adicionado
            'largura' => $request->largura, // Adicionado
        ]);

        // Redireciona para a página anterior
    //return redirect($request->input('redirect_to'))->with('success', 'Avaliação enviada!');
    return redirect()->back()->with('success', 'Avaliação enviada!')->withHeaders(['Cache-Control' => 'no-cache, must-revalidate']);

    }
}
