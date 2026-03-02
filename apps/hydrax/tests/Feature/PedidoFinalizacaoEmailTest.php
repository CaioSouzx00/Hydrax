<?php

namespace Tests\Feature;

use App\Mail\ChavePixMail;
use App\Mail\PedidoAtualizadoMail;
use App\Models\Carrinho;
use App\Models\CarrinhoItem;
use App\Models\EnderecoUsuario;
use App\Models\Pedido;
use App\Models\ProdutoEstoque;
use App\Models\ProdutoFornecedor;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PedidoFinalizacaoEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_finalizar_compra_cria_pedido_debita_estoque_e_envia_emails(): void
    {
        Mail::fake();

        $usuario = Usuario::factory()->create();
        $endereco = EnderecoUsuario::factory()->create(['id_usuarios' => $usuario->id_usuarios]);

        $produto = ProdutoFornecedor::factory()->create(['ativo' => true]);
        ProdutoEstoque::factory()->create([
            'produto_id' => $produto->id_produtos,
            'tamanho' => '40',
            'quantidade' => 5,
        ]);

        $carrinho = Carrinho::factory()->create([
            'id_usuarios' => $usuario->id_usuarios,
            'status' => 'ativo',
        ]);

        CarrinhoItem::factory()->create([
            'carrinho_id' => $carrinho->id,
            'produto_id' => $produto->id_produtos,
            'tamanho' => '40',
            'quantidade' => 2,
        ]);

        $response = $this->actingAs($usuario, 'usuarios')
            ->post(route('carrinho.processar'), ['id_endereco' => $endereco->id_endereco]);

        $response->assertStatus(200);

        $pedido = Pedido::query()->where('usuario_id', $usuario->id_usuarios)->first();
        $this->assertNotNull($pedido);

        $estoqueAtual = ProdutoEstoque::query()
            ->where('produto_id', $produto->id_produtos)
            ->where('tamanho', '40')
            ->value('quantidade');

        $this->assertSame(3, (int)$estoqueAtual);

        Mail::assertSent(ChavePixMail::class);
        Mail::assertSent(PedidoAtualizadoMail::class);
    }
}
