<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o admin está autenticado no guard 'admin'
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->withErrors(['acesso' => 'Faça login para acessar o painel.']);
        }

        return $next($request);
    }
}
