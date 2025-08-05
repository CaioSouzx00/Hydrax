<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FornecedorPendente extends Model
{
    protected $table = 'fornecedores_pendentes';

    // Definindo a chave primária correta
    protected $primaryKey = 'id_fornecedores';

    // Se a chave for auto-increment (geralmente é), deixe true
    public $incrementing = true;

    // Tipo da chave primária (int ou string)
    protected $keyType = 'int';

    protected $fillable = [
        'nome_empresa',
        'cnpj',
        'email',
        'telefone',
        'foto',
        'password',
        'status',
    ];

    // Hash automático da senha ao atribuir
    public function setSenhaAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
