<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Carrinho;

class CarrinhoAbandonadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $carrinho;

    public function __construct(Carrinho $carrinho)
    {
        $this->carrinho = $carrinho;
    }

    public function build()
    {
        return $this->subject('Você esqueceu algo no carrinho 🛒')
                    ->view('emails.carrinho_abandonado');
    }
}
