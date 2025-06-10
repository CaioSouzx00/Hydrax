<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    protected $fillable = [
        'nome_empresa',
        'cnpj',
        'email',
        'telefone',
        'senha',
    ];

    public $timestamps = false; // Se a tabela não tiver created_at/updated_at
}
