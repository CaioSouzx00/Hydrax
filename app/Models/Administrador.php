<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrador extends Authenticatable
{
    protected $table = 'administradores';

    protected $fillable = [
        'nome_usuario',
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'nome_usuario';
    }
}
