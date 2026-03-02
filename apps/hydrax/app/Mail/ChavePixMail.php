<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChavePixMail extends Mailable
{
    use Queueable, SerializesModels;

    public $chavePix;
    public $total;

    public function __construct($chavePix, $total)
    {
        $this->chavePix = $chavePix;
        $this->total = $total;
    }

    public function build()
    {
        return $this->subject('Sua chave Pix para pagamento - Hydrax')
                    ->view('emails.chave_pix');
    }
}

