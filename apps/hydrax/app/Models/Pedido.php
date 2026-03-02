<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'endereco_id',
        'status',
        'subtotal',
        'taxa_entrega',
        'desconto',
        'total',
        'chave_pix',
        'cupom_aplicado',
        'codigo_rastreio',
        'url_rastreio',
    ];

    protected $casts = [
        'cupom_aplicado' => 'array',
    ];

    public function itens()
    {
        return $this->hasMany(PedidoItem::class, 'pedido_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuarios');
    }

    public function endereco()
    {
        return $this->belongsTo(EnderecoUsuario::class, 'endereco_id', 'id_endereco');
    }

    public function lancamentosVenda()
    {
        return $this->hasMany(VendaLancamento::class, 'pedido_id');
    }
}
