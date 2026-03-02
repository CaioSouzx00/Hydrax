<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';

    protected $fillable = [
        'nome',
        'slug',
        'ativo',
    ];

    public function produtos()
    {
        return $this->hasMany(ProdutoFornecedor::class, 'marca_id');
    }
}
