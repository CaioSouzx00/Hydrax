<?php

namespace Tests\Feature;

use App\Mail\PedidoAtualizadoMail;
use App\Models\EnderecoUsuario;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\ProdutoEstoque;
use App\Models\ProdutoFornecedor;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PedidoCancelamentoEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_cancela_pedido_reposiciona_estoque_e_envia_email(): void
    {
        Mail::fake();

        $usuario = Usuario::factory()->create();
        $endereco = EnderecoUsuario::factory()->create(['id_usuarios' => $usuario->id_usuarios]);

        $produto = ProdutoFornecedor::factory()->create(['ativo' => true]);
        ProdutoEstoque::factory()->create([
            'produto_id' => $produto->id_produtos,
            'tamanho' => '40',
            'quantidade' => 1,
        ]);

        $pedido = Pedido::factory()->create([
            'usuario_id' => $usuario->id_usuarios,
            'endereco_id' => $endereco->id_endereco,
            'status' => 'finalizado',
        ]);

        PedidoItem::factory()->create([
            'pedido_id' => $pedido->id,
            'produto_id' => $produto->id_produtos,
            'tamanho' => '40',
            'quantidade' => 2,
            'preco_unitario' => 100,
            'subtotal' => 200,
        ]);

        $response = $this->actingAs($usuario, 'usuarios')
            ->post(route('pedidos.cancelar', ['pedido' => $pedido->id]));

        $response->assertRedirect(route('pedidos.detalhe', $pedido->id));

        $pedido->refresh();
        $this->assertSame('cancelado', $pedido->status);

        $estoqueAtual = ProdutoEstoque::query()
            ->where('produto_id', $produto->id_produtos)
            ->where('tamanho', '40')
            ->value('quantidade');

        $this->assertSame(3, (int)$estoqueAtual);

        Mail::assertSent(PedidoAtualizadoMail::class);
    }
}
