<?php

namespace Tests\Feature;

use App\Models\Fornecedor;
use App\Models\ProdutoFornecedor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FornecedorProdutoUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_fornecedor_consegue_cadastrar_produto_com_fotos_e_elas_sao_salvas_no_public_disk(): void
    {
        Storage::fake('public');

        $fornecedor = Fornecedor::factory()->create();

        $payload = [
            'nome' => 'Air Zoom Test',
            'descricao' => 'Desc',
            'preco' => 199.90,
            'caracteristicas' => 'Carac',
            'cor' => 'Preto',
            'historico_modelos' => null,
            'tamanhos_disponiveis' => '38,39,40',
            'genero' => 'UNISSEX',
            'categoria' => 'TENIS',
            'marca_id' => null,
            'ativo' => 1,
            'fotos' => [UploadedFile::fake()->create('foto1.jpg', 10, 'image/jpeg')],
            'estoque_imagem' => [UploadedFile::fake()->create('estoque1.jpg', 10, 'image/jpeg')],
        ];

        $response = $this->actingAs($fornecedor, 'fornecedores')
            ->post(route('fornecedores.produtos.store'), $payload);

        $response->assertRedirect(route('fornecedores.produtos.index'));

        $produto = ProdutoFornecedor::query()->first();
        $this->assertNotNull($produto);
        $this->assertIsArray($produto->fotos);
        $this->assertNotEmpty($produto->fotos);

        Storage::disk('public')->assertExists($produto->fotos[0]);
    }
}
