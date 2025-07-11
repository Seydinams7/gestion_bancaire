<?php
// app/Notifications/VirementNotification.php

namespace App\Notifications;


use Illuminate\Notifications\Messages\DatabaseMessage;

class VirementNotification
{
    public $virement;

    public function __construct($virement)
    {
        $this->virement = $virement;
    }

    public function via($notifiable)
    {
        return ['database'];  // Ici, on choisit le canal de notification (par exemple, 'database', 'mail', etc.)
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Un virement de ' . $this->virement['montant'] . ' a été effectué.',
            'type' => 'Virement',
            'url' => route('dashboard'), // Lien vers la page de destination
        ];
    }
}
