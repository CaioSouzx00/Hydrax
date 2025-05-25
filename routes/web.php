<?php

use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('usuarios.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
});

Route::get('/usuarios/cadastrar', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::get('/login', [UsuarioController::class, 'showLoginForm'])->name('login.form');

Route::post('login', [UsuarioController::class, 'login'])->name('login.process');

Route::post('logout', [UsuarioController::class, 'logout'])->name('logout');