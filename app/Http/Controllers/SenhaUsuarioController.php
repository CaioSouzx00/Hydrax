<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodigoVerificacaoMail;


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



public function verificarCodigo(Request $request)
{
    $usuario = Auth::guard('usuarios')->user();

    if (!$usuario) {
        return redirect()->route('login')->withErrors(['msg' => 'Faça login para verificar o código.']);
    }

    $codigoCache = Cache::get('codigo_verificacao_' . $usuario->id);

    if ($request->codigo == $codigoCache) {
        Cache::forget('codigo_verificacao_' . $usuario->id);
        return view('usuarios.partials.trocar_senha');
    } else {
        return back()->withErrors(['codigo' => 'Código incorreto ou expirado.']);
    }
}


public function mostrarFormularioVerificarCodigo()
{
    $usuario = Auth::guard('usuarios')->user();
    if ($usuario) {
        $codigo = rand(100000, 999999);
        Cache::put('codigo_verificacao_' . $usuario->id, $codigo, now()->addMinutes(10));
        Mail::to($usuario->email)->send(new CodigoVerificacaoMail($codigo));
    }

    return view('usuarios.partials.verificar-codigo');
}







}
