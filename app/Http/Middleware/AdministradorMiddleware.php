<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            // Redireciona para a página de login do admin com mensagem
            return redirect()->route('admin.login')->withErrors(['acesso' => 'Faça login para acessar o sistema.']);
        }

        return $next($request);
    }
}
