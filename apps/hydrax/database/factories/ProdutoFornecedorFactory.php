<?php

namespace Database\Factories;

use App\Models\Fornecedor;
use App\Models\ProdutoFornecedor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ProdutoFornecedor>
 */
class ProdutoFornecedorFactory extends Factory
{
    protected $model = ProdutoFornecedor::class;

    public function definition(): array
    {
        $nome = fake()->words(3, true);

        return [
            'nome' => $nome,
            'descricao' => fake()->sentence(),
            'preco' => fake()->randomFloat(2, 50, 1200),
            'estoque_imagem' => null,
            'caracteristicas' => fake()->sentence(),
            'cor' => fake()->safeColorName(),
            'historico_modelos' => null,
            'tamanhos_disponiveis' => ['38', '39', '40'],
            'genero' => fake()->randomElement(['MASCULINO', 'FEMININO', 'UNISSEX']),
            'categoria' => fake()->randomElement(['TENIS', 'CORRIDA', 'CASUAL']),
            'fotos' => [],
            'slug' => Str::slug($nome) . '-' . uniqid(),
            'ativo' => true,
            'id_fornecedores' => Fornecedor::factory(),
        ];
    }
}
