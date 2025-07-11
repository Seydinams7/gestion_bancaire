<?php

namespace App\Mail;

use App\Models\CompteBancaire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteValide extends Mailable
{
    use Queueable, SerializesModels;

    public $compte;

    public function __construct(CompteBancaire $compte)
    {
        $this->compte = $compte;
    }

    public function build()
    {
        return $this->subject('Votre compte a été validé')
            ->view('emails.compte_valide');
    }
}
