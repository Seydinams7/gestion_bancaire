<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AjouterInteretsEpargne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ajouter-interets-epargne';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $comptes = CompteBancaire::where('type', 'epargne')->where('statut', 'valide')->get();

        foreach ($comptes as $compte) {
            $compte->solde += $compte->solde * 0.03;
            $compte->save();
        }

        $this->info('Intérêts ajoutés aux comptes épargne.');
    }

}
