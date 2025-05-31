<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrador extends Authenticatable
{
    protected $table = 'administradores';

    protected $fillable = ['nome_usuario', 'password'];

    public $timestamps = true;

    protected $hidden = ['password', 'remember_token'];

    // Se usa autenticação com remember me, precisa da coluna remember_token no DB
    // Caso use, pode adicionar a propriedade $casts para 'email_verified_at', se quiser
}
