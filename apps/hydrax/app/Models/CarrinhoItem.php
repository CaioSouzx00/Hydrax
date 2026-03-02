<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrinhoItem extends Model
{
    use HasFactory;

    protected $table = 'carrinho_itens';

    protected $fillable = ['carrinho_id', 'produto_id', 'quantidade', 'tamanho'];

    public function carrinho()
    {
        return $this->belongsTo(Carrinho::class, 'carrinho_id');
    }

    public function produto()
    {
        return $this->belongsTo(ProdutoFornecedor::class, 'produto_id');
    }
}

