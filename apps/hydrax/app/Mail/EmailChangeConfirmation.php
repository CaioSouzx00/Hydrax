<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailChangeConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $token;
    public $link;

    public function __construct($usuario, $token)
    {
        $this->usuario = $usuario;
        $this->token   = $token;
        // Monta o link completo para confirmar a troca de e-mail
        $this->link = url("/usuarios/email/confirmar/{$token}");
    }

    public function build()
    {
        return $this->subject('Confirme sua troca de e-mail')
                    ->view('emails.email_change_confirmation')
                    ->with([
                        'usuario' => $this->usuario,
                        'token'   => $this->token,
                        'link'    => $this->link,
                    ]);
    }
}
