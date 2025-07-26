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
use App\Http\Controllers\Auth\FornecedorPasswordResetController;
use App\Http\Controllers\ProdutoFornecedorController;
use App\Http\Controllers\SenhaUsuarioController;
use App\Http\Controllers\PrivacidadeController;
use App\Http\Controllers\ProdutoController;

Route::prefix('fornecedores/senha')->group(function () {
    // 1. Formulário para digitar o e-mail
    Route::get('/esqueci', [FornecedorPasswordResetController::class, 'mostrarFormulario'])->name('fornecedores.senha.form');
    // 2. Envio do código por e-mail
    Route::post('/enviar-codigo', [FornecedorPasswordResetController::class, 'enviarCodigo'])->name('fornecedores.senha.enviar');
    // 3. Formulário para digitar o código de verificação
    Route::get('/verificar', [FornecedorPasswordResetController::class, 'mostrarFormularioVerificacao'])->name('fornecedores.senha.verificar.form');
    // 4. Verificação do código
    Route::post('/verificar', [FornecedorPasswordResetController::class, 'verificarCodigo'])->name('fornecedores.senha.verificar');
    // 5. Formulário para redefinir a senha
    Route::get('/redefinir', [FornecedorPasswordResetController::class, 'mostrarFormularioRedefinir'])->name('fornecedores.senha.redefinir.form');
    // 6. Processamento da nova senha
    Route::post('/redefinir', [FornecedorPasswordResetController::class, 'redefinirSenha'])->name('fornecedores.senha.redefinir');
});

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

/*
|--------------------------------------------------------------------------
| Rotas Protegidas - Usuário (middleware: usuario)
|--------------------------------------------------------------------------
*/
Route::middleware([UsuarioMiddleware::class])->group(function () {

Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
Route::get('/painel', [UsuarioController::class, 'painel'])->name('usuario.painel');

Route::get('/usuarios/perfil', [UsuarioController::class, 'edit'])->name('usuario.perfil');
Route::put('/usuarios/perfil', [UsuarioController::class, 'update'])->name('usuario.update');

Route::get('/usuarios/enderecos/create', [EnderecoUsuarioController::class, 'create'])->name('usuarios.enderecos.create');
Route::post('/usuarios/enderecos', [EnderecoUsuarioController::class, 'store'])->name('usuarios.enderecos.store');

Route::get('/usuarios/enderecos', [EnderecoUsuarioController::class, 'index'])->name('usuarios.enderecos.index');
Route::get('/usuarios/enderecos/{endereco}/edit', [EnderecoUsuarioController::class, 'edit'])->name('usuarios.enderecos.edit');
Route::put('/usuarios/enderecos/{endereco}', [EnderecoUsuarioController::class, 'update'])->name('usuarios.enderecos.update');
Route::delete('/usuarios/enderecos/{endereco}', [EnderecoUsuarioController::class, 'destroy'])->name('usuarios.enderecos.destroy');

Route::get('/usuarios/email', [UsuarioController::class, 'showEmailForm'])->name('usuarios.email.form');
Route::post('/usuarios/email/update', [UsuarioController::class, 'updateEmailRequest'])->name('usuarios.email.update');
Route::get('/usuarios/email/confirmar/{token}', [UsuarioController::class, 'confirmarNovoEmail'])->name('usuarios.email.confirmar');


Route::get('/verificar', [SenhaUsuarioController::class, 'verificarForm'])->name('usuarios.senha.verificar.form');
Route::post('/verificar', [SenhaUsuarioController::class, 'verificar'])->name('usuarios.senha.verificar');
Route::get('/trocar', [SenhaUsuarioController::class, 'trocarForm'])->name('usuarios.senha.trocar.form');
Route::post('/trocar', [SenhaUsuarioController::class, 'trocar'])->name('usuarios.senha.trocar');


Route::post('/usuarios/senha/verificar-codigo', [SenhaUsuarioController::class, 'verificarCodigo'])->name('usuarios.senha.verificarCodigo');
Route::get('/usuarios/senha/verificar-codigo', [SenhaUsuarioController::class, 'mostrarFormularioVerificarCodigo'])->name('usuarios.senha.verificarCodigo.form');


Route::get('/privacidade', function () {
    return view('usuarios.partials.privacidade');
})->name('usuarios.privacidade');


Route::post('/excluir-conta', [PrivacidadeController::class, 'excluirConta'])->name('usuarios.excluir-conta');


});

Route::get('/produtos/buscar', [ProdutoController::class, 'buscar'])->name('produtos.buscar');

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
*/
Route::middleware([FornecedorMiddleware::class])->prefix('fornecedores')->name('fornecedores.')->group(function () {
    Route::get('/dashboard', [FornecedorController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [FornecedorController::class, 'logout'])->name('logout');

    Route::get('/produtos', [ProdutoFornecedorController::class, 'index'])->name('produtos.index');

    Route::get('/produtos/create', [ProdutoFornecedorController::class, 'create'])->name('produtos.create');
    Route::post('/produtos/store', [ProdutoFornecedorController::class, 'store'])->name('produtos.store');

});