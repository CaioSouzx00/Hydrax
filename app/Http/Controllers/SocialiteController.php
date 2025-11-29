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

    // Buscar usuário por email
    $user = Usuario::where('email', $googleUser->email)->first();

    if (!$user) {
        // Criar usuário mínimo
        $user = Usuario::create([
            'email' => $googleUser->email,
            'nome_completo' => $googleUser->name ?? 'Sem Nome',
            'password' => bcrypt(Str::random(16)),
            'sexo' => null,
            'cpf' => null,
            'data_nascimento' => null,
            'telefone' => null,
            'google_id' => $googleUser->id,
        ]);
    }

    $user->refresh();

    // Autenticar
    Auth::guard('usuarios')->login($user);

    if (
        empty($user->cpf) ||
        empty($user->telefone) ||
        empty($user->sexo) ||
        empty($user->data_nascimento)
    ) {
        return redirect()->route('completarCadastroForm');
    }

    return redirect()->route('dashboard');
}


}
