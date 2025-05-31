<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrador;

class AdminController extends Controller
{
    // Mostrar formulário de login do admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Realiza o login do administrador
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nome_usuario' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'nome_usuario' => 'Usuário ou senha inválidos.',
        ])->withInput();
    }

    // Faz logout do administrador
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // Mostra o dashboard do administrador
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard', compact('admin'));
    }
}
