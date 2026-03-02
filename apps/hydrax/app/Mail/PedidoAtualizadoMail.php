<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoAtualizadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pedido $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        $status = strtoupper((string)($this->pedido->status ?? ''));

        return $this->subject("Atualização do pedido #{$this->pedido->id} - {$status}")
            ->view('emails.pedido_atualizado');
    }
}
