<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FornecedorRejeitadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fornecedor;

    public function __construct($fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    public function build()
    {
        return $this->subject('Cadastro Rejeitado - Hydrax')
                    ->view('emails.fornecedor_rejeitado')
                    ->with(['fornecedor' => $this->fornecedor]);
    }
}
