<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoFornecedor extends Model
{
    protected $table = 'produtos_fornecedores';

    protected $primaryKey = 'id_produtos';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $casts = [
    'tamanhos_disponiveis' => 'array',
    'fotos' => 'array',
];


    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'estoque_imagem',
        'caracteristicas',
        'historico_modelos',
        'tamanhos_disponiveis',
        'genero',
        'categoria',
        'fotos',
        'slug',
        'ativo',
        'id_fornecedores',
    ];
}
