<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\ProdutoFornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PedidoItem>
 */
class PedidoItemFactory extends Factory
{
    protected $model = PedidoItem::class;

    public function definition(): array
    {
        return [
            'pedido_id' => Pedido::factory(),
            'produto_id' => ProdutoFornecedor::factory(),
            'tamanho' => '40',
            'quantidade' => 1,
            'preco_unitario' => 100,
            'subtotal' => 100,
        ];
    }
}
