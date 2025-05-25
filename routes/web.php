<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EnderecoUsuarioController;
use App\Http\Controllers\Auth\PasswordResetController;

// Página inicial
Route::get('/', function () {
    return view('usuarios.dashboard');
});

// Login e Cadastro
Route::get('/login', [UsuarioController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.process');
Route::get('/usuarios/cadastrar', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

// Rotas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
});

// Endereços
Route::prefix('usuarios/{id}')->group(function () {
    Route::get('enderecos', [EnderecoUsuarioController::class, 'index'])->name('usuario.enderecos');
    Route::get('enderecos/create', [EnderecoUsuarioController::class, 'create'])->name('endereco.create');
    Route::post('enderecos', [EnderecoUsuarioController::class, 'store'])->name('endereco.store');
    Route::get('enderecos/{endereco_id}/edit', [EnderecoUsuarioController::class, 'edit'])->name('endereco.edit');
    Route::put('enderecos/{endereco_id}', [EnderecoUsuarioController::class, 'update'])->name('endereco.update');
    Route::delete('enderecos/{endereco_id}', [EnderecoUsuarioController::class, 'destroy'])->name('endereco.destroy');
});


// Exibe formulário "Esqueci minha senha"
Route::get('/senha/esqueci', [PasswordResetController::class, 'mostrarFormulario'])->name('password.esqueciSenhaForm');

// Envia código por e-mail
Route::post('/senha/enviar-codigo', [PasswordResetController::class, 'enviarCodigo'])->name('password.enviarCodigo');

// Formulário para digitar código
Route::get('/senha/verificar-codigo', [PasswordResetController::class, 'mostrarFormularioVerificacao'])->name('password.verificarCodigoForm');

// Valida o código e redireciona
Route::post('/senha/verificar-codigo', [PasswordResetController::class, 'verificarCodigo'])->name('password.verificarCodigo');

// Formulário para redefinir senha
Route::get('/senha/redefinir', [PasswordResetController::class, 'mostrarFormularioRedefinir'])->name('password.redefinirSenhaForm');

// Salva a nova senha
Route::post('/senha/redefinir', [PasswordResetController::class, 'redefinirSenha'])->name('password.redefinirSenha');
