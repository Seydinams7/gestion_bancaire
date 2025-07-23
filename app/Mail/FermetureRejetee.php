<?php

namespace App\Mail;

use App\Models\CompteBancaire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FermetureRejetee extends Mailable
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
        return $this->subject('Votre demande de fermeture de compte a été rejetée')
            ->view('emails.fermeture_rejetee');
    }
}