<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CompteBancaire;
use Carbon\Carbon;

class AppliquerInteretsEpargne extends Command
{
    protected $signature = 'interets:appliquer';
    protected $description = 'Appliquer 3% d’intérêt annuel aux comptes épargne';

    public function handle()
    {
        $comptes = CompteBancaire::where('type_compte', 'epargne')->get();

        foreach ($comptes as $compte) {
            // Vérifier s’il y a déjà eu un ajout d’intérêt cette année
            if (!$compte->interet_dernier_ajout || Carbon::parse($compte->interet_dernier_ajout)->lt(Carbon::now()->startOfYear())) {
                $ancienSolde = $compte->solde;
                $interet = $ancienSolde * 0.03;
                $compte->solde += $interet;
                $compte->interet_dernier_ajout = Carbon::now();
                $compte->save();

                $this->info("Intérêt appliqué au compte ID {$compte->id} : +$interet FCFA");
            }
        }

        $this->info('Application des intérêts terminée.');
    }
}
