<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contenido;
    public $asunto;
    public $cuenta;
    public $campaign;
    public $blocks;

    public function __construct($contenido, $asunto, $cuenta, $campaign, $blocks)
    {
        $this->contenido = $contenido;
        $this->asunto = $asunto;
        $this->cuenta = $cuenta;
        $this->campaign = $campaign;
        $this->blocks = $blocks;
    }

    public function build()
    {
        return $this->from($this->cuenta)
                    ->subject($this->asunto)
                    ->view('campaigns.correo')
                    ->with([
                        'contenido' => $this->contenido,
                        'campaign' => $this->campaign,
                        'blocks' => $this->blocks,
                    ]);
    }
}

