<?php

namespace App\Http\Controllers;

use App\Models\FornecedorPendente;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\FornecedorAprovadoMail;
use App\Mail\FornecedorRejeitadoMail;

class FornecedorController extends Controller
{
    public function showLoginForm()
    {
        return view('fornecedores.login');
    }

    public function create()
    {
        return view('fornecedores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_empresa' => 'required|string|max:255',
            'cnpj' => 'required|string|min:14|unique:fornecedores_pendentes,cnpj',
            'email' => 'required|email|unique:fornecedores_pendentes,email',
            'telefone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        FornecedorPendente::create([
            'nome_empresa' => $validated['nome_empresa'], 
            'cnpj' => $validated['cnpj'],
            'email' => $validated['email'],
            'telefone' => $validated['telefone'],
            'password' => $validated['password'],
            'status' => 'pendente',
            'foto' => null,
        ]);

        return redirect()->route('fornecedores.login')->with('success', 'Cadastro enviado para análise.');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    // Usar Auth::guard com o nome correto da guard: 'fornecedores'
        if (Auth::guard('fornecedores')->attempt($credentials)) {
            $request->session()->regenerate();  // ESSENCIAL para proteção CSRF
            return redirect()->route('fornecedores.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('fornecedores')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('fornecedores.login')->with('success', 'Você saiu do sistema.');
    }

    public function listarPendentes()
    {
        $pendentes = FornecedorPendente::all();
        return view('admin.verifyfornecedor', compact('pendentes'));
    }

    public function aprovar($id)
    {
        $pendente = FornecedorPendente::findOrFail($id);

        Fornecedor::create([
            'nome_empresa' => $pendente->nome_empresa,
            'cnpj' => $pendente->cnpj,
            'email' => $pendente->email,
            'telefone' => $pendente->telefone,
            'password' => Hash::make($pendente->password),
            'foto' => null,
        ]);

    // Enviar e-mail de aprovação
    Mail::to($pendente->email)->send(new FornecedorAprovadoMail($pendente));

        $pendente->delete();

        return redirect()->route('fornecedores.pendentes')->with('success', 'Fornecedor aprovado!');
    }

    public function rejeitar($id)
    {
        $pendente = FornecedorPendente::findOrFail($id);

    // Enviar e-mail de rejeição
        Mail::to($pendente->email)->send(new FornecedorRejeitadoMail($pendente));

        $pendente->delete();

        return redirect()->route('fornecedores.pendentes')->with('success', 'Fornecedor rejeitado!');
    }

    public function dashboard()
    {
        $fornecedor = Auth::guard('fornecedores')->user();
        return view('fornecedores.dashboard', compact('fornecedor'));
    }

    public function atualizarFoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fornecedor = Auth::guard('fornecedores')->user();

        if ($fornecedor->profile_photo) {
            Storage::disk('public')->delete($fornecedor->profile_photo);
        }

        $path = $request->file('profile_photo')->store('fotos_fornecedores', 'public');

        $fornecedor->profile_photo = $path;
        $fornecedor->save();

        return back()->with('success', 'Foto de perfil atualizada com sucesso!');
    }
}
