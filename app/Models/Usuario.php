<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuarios';

    public $timestamps = false; // Se não tem created_at e updated_at

    protected $fillable = [
        'sexo',
        'nome_completo',
        'data_nascimento',
        'email',
        'password', // lembre-se que seu campo no DB deve ser password (ou ajustar getAuthPassword)
        'telefone',
        'cpf',
        'foto',
    ];

    protected $hidden = ['password', 'remember_token']; // adiciona remember_token se usar

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function enderecos()
    {
        // FK na tabela endereco_usuarios: id_usuarios
        return $this->hasMany(EnderecoUsuario::class, 'id_usuarios', 'id_usuarios');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
