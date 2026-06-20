<?php

namespace App\Jobs;

use App\Models\Carrinho;
use App\Services\Novu\NovuService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarCarrinhoAbandonadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $carrinhoId;

    public function __construct($carrinhoId)
    {
        $this->carrinhoId = $carrinhoId;
    }

    public function handle()
    {
        $carrinho = Carrinho::with('itens.produto', 'usuario')
            ->find($this->carrinhoId);

        // Se carrinho não existe ou já foi finalizado, sai fora
        if (!$carrinho || $carrinho->status !== 'ativo' || $carrinho->itens->isEmpty()) {
            return;
        }

        $usuario = $carrinho->usuario;

        // Dispara o e-mail usando Novu
        $novuService = app(NovuService::class);
        $cartItems = $carrinho->itens->map(function ($item) {
            return [
                'produto_nome' => $item->produto->nome,
                'quantidade' => $item->quantidade,
                'preco' => $item->produto->preco,
            ];
        })->toArray();

        $novuService->sendCarrinhoAbandonado(
            subscriberId: (string)$usuario->id_usuarios,
            email: $usuario->email,
            userName: $usuario->nome_completo ?? $usuario->nome,
            cartItems: $cartItems
        );
    }
}
