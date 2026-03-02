<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UsuarioMiddleware
{
    public function handle(Request $request, Closure $next) : Response
    {
        // Verifica se o usuário está autenticado no guard 'usuarios'
        if (!Auth::guard('usuarios')->check()) {
            // Redireciona para a página de login do usuário com mensagem de erro
            return redirect()->route('login.form')->withErrors(['acesso' => 'Faça login para acessar o sistema.']);
        }

        return $next($request);
    }
}
