<?php

namespace Database\Factories;

use App\Models\ProdutoEstoque;
use App\Models\ProdutoFornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProdutoEstoque>
 */
class ProdutoEstoqueFactory extends Factory
{
    protected $model = ProdutoEstoque::class;

    public function definition(): array
    {
        return [
            'produto_id' => ProdutoFornecedor::factory(),
            'tamanho' => '40',
            'quantidade' => 10,
        ];
    }
}
