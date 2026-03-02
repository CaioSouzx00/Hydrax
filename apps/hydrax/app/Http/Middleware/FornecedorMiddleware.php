<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FornecedorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('fornecedores')->check()) {
            // Melhor redirecionar para a página de login do fornecedor com mensagem de erro
            return redirect()->route('fornecedores.login')->withErrors(['acesso' => 'Faça login para acessar o sistema.']);
        }

        return $next($request);
    }
}
