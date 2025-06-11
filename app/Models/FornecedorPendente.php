<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FornecedorPendente extends Model
{
    protected $table = 'fornecedores_pendentes';

    protected $fillable = [
        'nome_empresa', 'cnpj', 'email', 'telefone', 'senha', 'status',
    ];

    public function setSenhaAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }
}
