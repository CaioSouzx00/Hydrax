<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuarios'; // Necessário se você não usar 'id'

    protected $fillable = [
        'sexo',
        'nome_completo',
        'data_nascimento',
        'email',
        'senha',
        'telefone',
        'cpf',
        'foto',
    ];

    protected $hidden = ['senha'];
    protected $casts = ['data_nascimento' => 'date'];

    public function enderecos()
    {   
        return $this->hasMany(EnderecoUsuarioFinal::class, 'usuarios_id', 'id_usuarios');
    }
}

