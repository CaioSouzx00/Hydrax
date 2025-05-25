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
    public $timestamps = false;

    protected $fillable = [
        'sexo',
        'nome_completo',
        'data_nascimento',
        'email',
        'password',
        'telefone',
        'cpf',
        'foto',
    ];

    protected $hidden = ['password'];
    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function enderecos()
    {   
        return $this->hasMany(EnderecoUsuarioFinal::class, 'usuarios_id', 'id_usuarios');
    }

    // Se o campo da senha no banco for 'senha' (e não 'password'), informe explicitamente:
    public function getAuthPassword()
    {
        return $this->password;
    }
}
