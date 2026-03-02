<?php

namespace Database\Factories;

use App\Models\EnderecoUsuario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EnderecoUsuario>
 */
class EnderecoUsuarioFactory extends Factory
{
    protected $model = EnderecoUsuario::class;

    public function definition(): array
    {
        return [
            'id_usuarios' => Usuario::factory(),
            'cidade' => fake()->city(),
            'cep' => fake()->numerify('#####-###'),
            'bairro' => fake()->word(),
            'estado' => fake()->stateAbbr(),
            'rua' => fake()->streetName(),
            'numero' => (string)fake()->numberBetween(1, 9999),
            'is_principal' => false,
        ];
    }
}
