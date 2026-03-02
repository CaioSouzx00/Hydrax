<?php

namespace Database\Factories;

use App\Models\EnderecoUsuario;
use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pedido>
 */
class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(),
            'endereco_id' => EnderecoUsuario::factory(),
            'status' => 'finalizado',
            'subtotal' => 100,
            'taxa_entrega' => 15,
            'desconto' => 0,
            'total' => 115,
            'chave_pix' => 'hydrax-pix-' . fake()->bothify('##########'),
            'cupom_aplicado' => null,
            'codigo_rastreio' => null,
            'url_rastreio' => null,
        ];
    }
}
