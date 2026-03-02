<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    use HasFactory;

    protected $table = 'cupons';
    protected $primaryKey = 'id_cupom';

    protected $fillable = [
        'codigo',
        'tipo',
        'valor',
        'validade',
        'uso_maximo',
        'ativo'
    ];
}
