<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado no guard 'usuarios'
        if (!Auth::guard('usuarios')->check()) {
            // Redireciona para a página de login do usuário com mensagem de erro
            return redirect()->route('login.form')->withErrors(['acesso' => 'Faça login para acessar o sistema.']);
            // Alternativa: exibir uma view customizada com erro
            return response()->view('errors.sem-acesso');
        }

        return $next($request);
    }
}
