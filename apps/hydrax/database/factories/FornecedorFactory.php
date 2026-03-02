<?php

namespace Database\Factories;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Fornecedor>
 */
class FornecedorFactory extends Factory
{
    protected $model = Fornecedor::class;

    public function definition(): array
    {
        return [
            'nome_empresa' => fake()->unique()->company(),
            'cnpj' => fake()->unique()->numerify('##############'),
            'telefone' => fake()->phoneNumber(),
            'foto' => null,
            'email' => fake()->unique()->safeEmail(),
            'status' => 'ATIVO',
            'password' => Hash::make('password'),
        ];
    }
}
