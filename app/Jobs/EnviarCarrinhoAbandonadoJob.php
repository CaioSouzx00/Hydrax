<?php

namespace App\Jobs;

use App\Models\Carrinho;
use App\Mail\CarrinhoAbandonadoMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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

        // Dispara o e-mail
        Mail::to($usuario->email)->send(new CarrinhoAbandonadoMail($carrinho));
    }
}
