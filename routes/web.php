<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EnderecoUsuarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PasswordResetController;
use \App\Http\Middleware\UsuarioMiddleware;
use App\Http\Middleware\AdministradorMiddleware;
use App\Http\Middleware\FornecedorMiddleware;
use App\Http\Controllers\FornecedorController;


/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('usuarios.dashboard'); // Pode trocar por uma página pública
});

// Login e Cadastro - Usuário
Route::get('/login', [UsuarioController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.process');
Route::get('/usuarios/cadastrar', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

// Login - Admin
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

// Login - Fornecedores
Route::get('/fornecedores/login', [FornecedorController::class, 'showLoginForm'])->name('fornecedores.login');
Route::post('/fornecedores/login', [FornecedorController::class, 'login'])->name('fornecedores.login.submit');

Route::get('/fornecedores/create', [FornecedorController::class, 'create'])->name('fornecedores.create');
Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');

// Recuperação de Senha - Usuário
Route::get('/senha/esqueci', [PasswordResetController::class, 'mostrarFormulario'])->name('password.esqueciSenhaForm');
Route::post('/senha/enviar-codigo', [PasswordResetController::class, 'enviarCodigo'])->name('password.enviarCodigo');
Route::get('/senha/verificar-codigo', [PasswordResetController::class, 'mostrarFormularioVerificacao'])->name('password.verificarCodigoForm');
Route::post('/senha/verificar-codigo', [PasswordResetController::class, 'verificarCodigo'])->name('password.verificarCodigo');
Route::get('/senha/redefinir', [PasswordResetController::class, 'mostrarFormularioRedefinir'])->name('password.redefinirSenhaForm');
Route::post('/senha/redefinir', [PasswordResetController::class, 'redefinirSenha'])->name('password.redefinirSenha');

// Logout geral
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas - Usuário (middleware: usuario)
|--------------------------------------------------------------------------
*/
//Route::middleware('auth')->group(function () {
Route::middleware([UsuarioMiddleware::class])->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

    // Endereços do Usuário
    Route::prefix('usuarios/{id}')->group(function () {
        Route::get('enderecos', [EnderecoUsuarioController::class, 'index'])->name('usuario.enderecos');
        Route::get('enderecos/create', [EnderecoUsuarioController::class, 'create'])->name('endereco.create');
        Route::post('enderecos', [EnderecoUsuarioController::class, 'store'])->name('endereco.store');
        Route::get('enderecos/{endereco_id}/edit', [EnderecoUsuarioController::class, 'edit'])->name('endereco.edit');
        Route::put('enderecos/{endereco_id}', [EnderecoUsuarioController::class, 'update'])->name('endereco.update');
        Route::delete('enderecos/{endereco_id}', [EnderecoUsuarioController::class, 'destroy'])->name('endereco.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas - Administrador (middleware: admin)
|--------------------------------------------------------------------------
*/
Route::middleware([AdministradorMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard/dados-graficos', [AdminController::class, 'dadosGraficos'])->name('dashboard.dadosGraficos');
    Route::get('/fornecedores/pendentes', [FornecedorController::class, 'listarPendentes'])->name('fornecedores.pendentes');
    Route::post('/fornecedores/{id}/aprovar', [FornecedorController::class, 'aprovar'])->name('fornecedores.aprovar');
    Route::post('/fornecedores/{id}/rejeitar', [FornecedorController::class, 'rejeitar'])->name('fornecedores.rejeitar');

});

/*
|--------------------------------------------------------------------------
| (Opcional) Rotas Protegidas - Fornecedor (middleware: fornecedor)
|--------------------------------------------------------------------------
| Adicione aqui as rotas dos fornecedores, se for o caso.
| Exemplo:
| Route::middleware(['fornecedor'])->group(function () {
|     Route::get('/fornecedor/dashboard', ...);
| });
*/