<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FornecedorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('fornecedor')->check()) {
            // Melhor redirecionar para a página de login do fornecedor com mensagem de erro
            return redirect()->route('fornecedor.login.form')->withErrors(['acesso' => 'Faça login para acessar o sistema.']);
            // Ou, se quiser usar view, mantenha a resposta da view:
            // return response()->view('errors.sem-acesso');
        }

        return $next($request);
    }
}
