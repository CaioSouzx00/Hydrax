<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PrivacidadeController extends Controller
{
    public function excluirConta(Request $request)
{
    $usuario = Auth::guard('usuarios')->user();

    if (!$usuario) {
        return response()->json(['mensagem' => 'Usuário não autenticado'], 401);
    }

    $usuario->data_exclusao_agendada = now()->addDays(0);
    $usuario->save();

    return response()->json(['mensagem' => 'Sua conta foi agendada para exclusão em 3 dias.']);
}

}