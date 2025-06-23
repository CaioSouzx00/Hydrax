<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoFornecedor extends Model
{
    protected $table = 'produtos_fornecedores';

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
];

}

