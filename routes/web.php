<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('usuarios.dashboard');
});

// Login e cadastro
Route::get('/login', [UsuarioController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.process');

Route::get('/usuarios/cadastrar', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
});
