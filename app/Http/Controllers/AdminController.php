<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Administrador;
// use App\Models\FornecedorPendente; // Comentado porque não está usando ainda

class AdminController extends Controller
{
    // Mostrar form login admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Login admin
    public function login(Request $request)
    {
        $request->validate([
            'nome_usuario' => 'required',
            'password' => 'required',
        ]);

        $admin = Administrador::where('nome_usuario', $request->nome_usuario)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['nome_usuario' => 'Usuário ou senha inválidos'])->withInput();
        }

        // Usar o nome correto da chave primária na session
        session(['admin_id' => $admin->id_administradores]);

        return redirect()->route('admin.dashboard');
    }

    // Logout admin
    public function logout()
    {
        session()->forget('admin_id');
        return redirect()->route('admin.login.form');
    }

    // Dashboard admin simples (sem dados de fornecedores)
    public function dashboard()
    {
        $adminId = session('admin_id');
        // Buscar pelo campo correto
        $admin = Administrador::where('id_administradores', $adminId)->first();

        // Opcional: redirecionar se não estiver logado
        if (!$admin) {
            return redirect()->route('admin.login.form');
        }

        return view('admin.dashboard', compact('admin'));

        /*
        // Código para fornecedores pendentes, desativado por enquanto
        $fornecedoresPendentes = FornecedorPendente::where('status', 'pendente')->get();
        $quantidadePendentes = $fornecedoresPendentes->count();

        return view('admin.dashboard', compact('fornecedoresPendentes', 'quantidadePendentes'));
        */
    }

    /*
    // Método para dados gráficos, desativado por enquanto
    public function dadosGraficos()
    {
        // Seu código para dados gráficos aqui, comentado

        /*
        $usuariosPorMes = DB::table('usuarios')
            ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'mes');
        
        // ...
        
        return response()->json([
            'labels' => $labels,
            'usuarios' => $usuarios,
            'fornecedores' => $fornecedores,
        ]);
        */
    }