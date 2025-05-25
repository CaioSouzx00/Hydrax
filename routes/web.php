<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EnderecoUsuarioController;

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
