<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrador extends Authenticatable
{
    use HasFactory;

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
