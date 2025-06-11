<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Fornecedor extends Authenticatable
{
    use Notifiable;

    protected $table = 'fornecedores';

    protected $primaryKey = 'id_fornecedores';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'nome_empresa',
        'cnpj',
        'email',
        'telefone',
        'password',
        'status',
    ];

    protected $hidden = ['password'];

    public function setSenhaAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
