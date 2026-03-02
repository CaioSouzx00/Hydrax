<?php

namespace Database\Factories;

use App\Models\Carrinho;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Carrinho>
 */
class CarrinhoFactory extends Factory
{
    protected $model = Carrinho::class;

    public function definition(): array
    {
        return [
            'id_usuarios' => Usuario::factory(),
            'status' => 'ativo',
        ];
    }
}
