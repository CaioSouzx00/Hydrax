<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'administradores';
    protected $fillable = ['nome_usuario', 'password']; // ajusta aqui conforme seu banco
    public $timestamps = true; // seu banco tem created_at e updated_at, então timestamps ficam true

    protected $hidden = ['password']; // para não mostrar a senha em JSON, por exemplo
}