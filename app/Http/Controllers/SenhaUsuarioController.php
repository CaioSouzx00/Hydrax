<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SenhaUsuarioController extends Controller
{
    public function verificarForm()
    {
        return view('usuarios.partials.verificar_senha');
    }

    public function verificar(Request $request)
    {
        $request->validate([
            'senha_atual' => 'required|string',
        ]);

        $user = Auth::guard('usuarios')->user(); // use o mesmo guard sempre

        if (!Hash::check($request->senha_atual, $user->password)) {
            return response('Senha incorreta.', 401);
        }

        // Se senha correta, retorna a view da troca de senha
        return view('usuarios.partials.trocar_senha');
    }

    public function trocarForm()
    {
        return view('usuarios.partials.trocar_senha');
    }

    public function trocar(Request $request)
{

    $request->validate([
        'nova_senha' => 'required|min:6|confirmed',
    ]);

    $user = Auth::guard('usuarios')->user();

    $user->password = Hash::make($request->nova_senha);
    $user->save();

    return response()->json(['sucesso' => 'Senha alterada com sucesso.']);
}

}
