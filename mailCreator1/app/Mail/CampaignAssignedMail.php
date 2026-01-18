<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Campaigns;
use App\Models\CampaignCollaborator;

class CampaignAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $collaboration;
    public $assignedBy;

    public function __construct(Campaigns $campaign, CampaignCollaborator $collaboration, $assignedBy)
    {
        $this->campaign = $campaign;
        $this->collaboration = $collaboration;
        $this->assignedBy = $assignedBy;
    }

    public function build()
    {
        // Usar MAIL_FROM_ADDRESS de .env si existe, si no un valor por defecto
        $fromAddress = config('mail.from.address') ?: 'mailCreator@udla.edu.ec';
        $fromName = config('mail.from.name') ?: 'mailCreator';

        return $this->from($fromAddress, $fromName)
                    ->subject('Nueva Campaña Asignada: ' . $this->campaign->title)
                    ->view('emails.campaign-assigned');
    }
}
