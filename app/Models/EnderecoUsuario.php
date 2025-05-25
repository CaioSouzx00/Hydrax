<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoUsuario extends Model
{
    use HasFactory;

    protected $table = 'endereco_usuarios';

    protected $primaryKey = 'id_endereco';

    protected $fillable = [
        'id_usuarios',
        'cidade',
        'cep',
        'bairro',
        'estado',
        'rua',
        'numero'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuarios');
    }
}