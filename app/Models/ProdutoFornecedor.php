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
    'estoque_imagem' => 'array',
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


   public function fornecedor()
{
    return $this->belongsTo(Fornecedor::class, 'id_fornecedores', 'id_fornecedores');
}

    public function scopeAtivos($query)
    {
        return $query->where('ativo', 1);
    }


public function carrinhoItens()
{
    return $this->hasMany(CarrinhoItem::class, 'produto_id', 'id_produtos');
}

public function avaliacoes()
{
    return $this->hasMany(Avaliacao::class, 'id_produtos', 'id_produtos');
}



}
