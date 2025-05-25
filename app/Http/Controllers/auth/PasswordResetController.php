<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Exibe o formulário para informar o e-mail (esqueci a senha)
    public function mostrarFormulario()
    {
        return view('usuarios.forgot-password'); // View para pedir e-mail
    }

    // Envia o código de recuperação para o e-mail informado
    public function enviarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
        ]);

        // Gera um código numérico de 6 dígitos
        $token = random_int(100000, 999999);

        // Salva ou atualiza o código na tabela password_resets
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Renderiza o conteúdo do e-mail a partir da view
        $html = view('emails.recuperacao', ['token' => $token])->render();

        // Envia o e-mail com o código
        Mail::html($html, function ($message) use ($request) {
            $message->to($request->email)
                ->from('caionk03@gmail.com', 'Hydrax')
                ->subject('Código de Recuperação de Senha');
        });

        // Redireciona para o formulário de verificação do código, enviando o e-mail como parâmetro
        return redirect()->route('password.verificarCodigoForm', ['email' => $request->email])
                         ->with('success', 'Código enviado para seu e-mail.');
    }

    // Exibe o formulário para o usuário digitar o código recebido
    public function mostrarFormularioVerificacao(Request $request)
    {
        $email = $request->email;
        return view('usuarios.verify-code', compact('email'));
    }

    // Verifica se o código digitado pelo usuário é válido
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
            'token' => 'required|numeric',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'Código inválido ou expirado.']);
        }

        // Redireciona para o formulário de redefinição de senha com email e token
        return redirect()->route('password.redefinirSenhaForm', ['email' => $request->email, 'token' => $request->token]);
    }

    // Exibe o formulário para redefinir a senha
    public function mostrarFormularioRedefinir(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        $reset = DB::table('password_resets')
                    ->where('email', $email)
                    ->where('token', $token)
                    ->first();

        if (!$reset) {
            return redirect()->route('password.esqueciSenhaForm')
                             ->withErrors(['token' => 'O código de recuperação é inválido ou expirou.']);
        }

        return view('usuarios.reset-password', compact('email', 'token'));
    }

    // Atualiza a senha do usuário no banco
   public function redefinirSenha(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:usuarios,email',
        'password' => 'required|string|min:6|confirmed',
        'token' => 'required',
    ]);

    $reset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->token)
                ->first();

    if (!$reset) {
        return redirect()->route('login.form')
                         ->withErrors(['token' => 'O código de recuperação é inválido ou expirou.']);
    }

    // Define as variáveis para o update
    $email = $request->email;
    $novaSenha = $request->password;

    // Atualiza a senha, usando Hash para segurança
    DB::table('usuarios')
        ->where('email', $email)
        ->update(['password' => Hash::make($novaSenha)]);

    // Remove o token da tabela password_resets
    DB::table('password_resets')->where('email', $email)->delete();

    // Redireciona para o formulário de login com sucesso
    return redirect()->route('login.form')->with('success', 'Senha redefinida com sucesso.');
}
}