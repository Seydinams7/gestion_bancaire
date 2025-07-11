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

    public function __construct(CompteBancaire $compte)
    {
        $this->compte = $compte;
    }

    public function build()
    {
        return $this->subject('Votre demande de compte a été rejetée')
            ->view('emails.compte_rejete');
    }
}
