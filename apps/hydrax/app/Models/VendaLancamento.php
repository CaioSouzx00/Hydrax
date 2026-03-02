<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendaLancamento extends Model
{
    protected $table = 'venda_lancamentos';

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'fornecedor_id',
        'tamanho',
        'quantidade',
        'preco_unitario',
        'subtotal',
        'lancado_em',
    ];

    protected $casts = [
        'lancado_em' => 'datetime',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function produto()
    {
        return $this->belongsTo(ProdutoFornecedor::class, 'produto_id', 'id_produtos');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id', 'id_fornecedores');
    }
}
