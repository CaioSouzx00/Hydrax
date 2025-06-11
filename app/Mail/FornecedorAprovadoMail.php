<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FornecedorAprovadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fornecedor;

    public function __construct($fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    public function build()
    {
        return $this->subject('Cadastro Aprovado - Bem-vindo ao Hydrax!')
                    ->view('emails.fornecedor_aprovado')
                    ->with(['fornecedor' => $this->fornecedor]);
    }
}
