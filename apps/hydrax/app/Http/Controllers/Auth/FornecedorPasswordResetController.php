<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class FornecedorPasswordResetController extends Controller
{
    public function mostrarFormulario()
    {
        return view('fornecedores.forgot-password');
    }

    public function enviarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:fornecedores,email',
        ]);

        $token = random_int(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $html = view('emails.recuperacao_fornecedor', ['token' => $token])->render();

        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)
                    ->from('caionk03@gmail.com', 'Hydrax')
                    ->subject('Código de Recuperação de Senha - Fornecedor');
        });

        return redirect()->route('fornecedores.senha.verificar.form', ['email' => $request->email])
                         ->with('success', 'Código enviado para seu e-mail.');
    }

    public function mostrarFormularioVerificacao(Request $request)
    {
        $email = $request->email;
        return view('fornecedores.verify-code', compact('email'));
    }

    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:fornecedores,email',
            'token' => 'required|numeric',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'Código inválido ou expirado.']);
        }

        return redirect()->route('fornecedores.senha.redefinir.form', [
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    public function mostrarFormularioRedefinir(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        $reset = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$reset) {
            return redirect()->route('fornecedores.senha.form')
                             ->withErrors(['token' => 'O código de recuperação é inválido ou expirou.']);
        }

        return view('fornecedores.reset-password', compact('email', 'token'));
    }

    public function redefinirSenha(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:fornecedores,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return redirect()->route('fornecedores.senha.form')
                             ->withErrors(['token' => 'O código de recuperação é inválido ou expirou.']);
        }

        DB::table('fornecedores')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('fornecedores.login')->with('success', 'Senha redefinida com sucesso.');
    }
}
