<?php

namespace App\Mail;

use App\Models\CompteBancaire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteRejete extends Mailable
{
    use Queueable, SerializesModels;

    public $compte;
    public $raison;

    public function __construct(CompteBancaire $compte, $raison = null)
    {
        $this->compte = $compte;
        $this->raison = $raison;
    }

    public function build()
    {
        return $this->subject('Votre demande d\'ouverture de compte a été rejetée')
            ->view('emails.compte_rejete');
    }
}