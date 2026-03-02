<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nome_completo' => fake()->name(),
            'sexo' => fake()->randomElement(['M', 'F', 'O']),
            'data_nascimento' => fake()->date(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'telefone' => fake()->phoneNumber(),
            'cpf' => fake()->numerify('###########'),
            'google_id' => null,
            'data_exclusao_agendada' => null,
        ];
    }
}
