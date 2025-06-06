<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware 
{
    /**
     * Redireciona o usuário para a rota de login apropriada conforme o guard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Verifica se está acessando rotas do administrador
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // Verifica se está acessando rotas do fornecedor
            if ($request->is('fornecedor') || $request->is('fornecedor/*')) {
                return route('fornecedor.login');
            }

            // Qualquer outro caso: assume que é um usuário final
            return route('login.form'); // <-- Corrigido: essa é sua rota de login de usuário
        }
    }
}
