<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

   public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Erro ao logar com Google.');
    }

    // Verificar se já existe usuário com este email
    $user = Usuario::where('email', $googleUser->email)->first();

    if (!$user) {
        // Criar usuário mínimo necessário para logar
        $user = Usuario::create([
            'email' => $googleUser->email,
            'nome_completo' => $googleUser->name,
            'password' => bcrypt(Str::random(16)),
            'sexo' => null,
            'cpf' => null,
            'data_nascimento' => null,
            'telefone' => null,
            'google_id' => $googleUser->id,
        ]);
    }

    Auth::guard('usuarios')->login($user);

    // Se faltam dados obrigatórios → mandar completar perfil
    if (
        !$user->cpf ||
        !$user->telefone ||
        !$user->sexo ||
        !$user->data_nascimento
    ) {
        return redirect('/completar-cadastro');
    }

    // Se já tem tudo → dashboard direto
    return redirect('/dashboard');
}


}
