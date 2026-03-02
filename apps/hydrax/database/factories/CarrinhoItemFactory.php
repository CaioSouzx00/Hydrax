<?php

namespace Database\Factories;

use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Models\ProdutoFornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarrinhoItem>
 */
class CarrinhoItemFactory extends Factory
{
    protected $model = CarrinhoItem::class;

    public function definition(): array
    {
        return [
            'carrinho_id' => Carrinho::factory(),
            'produto_id' => ProdutoFornecedor::factory(),
            'quantidade' => 1,
            'tamanho' => '40',
        ];
    }
}
