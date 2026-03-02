<?php

namespace Tests\Feature;

use App\Mail\PedidoAtualizadoMail;
use App\Models\Administrador;
use App\Models\EnderecoUsuario;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\ProdutoFornecedor;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminAtualizaPedidoEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_atualiza_pedido_e_envia_email(): void
    {
        Mail::fake();

        $admin = Administrador::factory()->create();
        $usuario = Usuario::factory()->create();
        $endereco = EnderecoUsuario::factory()->create(['id_usuarios' => $usuario->id_usuarios]);
        $produto = ProdutoFornecedor::factory()->create(['ativo' => true]);

        $pedido = Pedido::factory()->create([
            'usuario_id' => $usuario->id_usuarios,
            'endereco_id' => $endereco->id_endereco,
            'status' => 'pago',
        ]);

        PedidoItem::factory()->create([
            'pedido_id' => $pedido->id,
            'produto_id' => $produto->id_produtos,
            'tamanho' => '40',
            'quantidade' => 1,
            'preco_unitario' => 100,
            'subtotal' => 100,
        ]);

        $response = $this->actingAs($admin, 'admin')->post(route('admin.pedidos.update', ['id' => $pedido->id]), [
            'status' => 'enviado',
            'codigo_rastreio' => 'BR123',
            'url_rastreio' => 'https://exemplo.com/rastreio',
        ]);

        $response->assertRedirect();

        $pedido->refresh();
        $this->assertSame('enviado', $pedido->status);

        Mail::assertSent(PedidoAtualizadoMail::class);
    }
}
