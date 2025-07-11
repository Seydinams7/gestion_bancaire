<?php

namespace App\Http\Controllers;

use App\Models\CompteBancaire;
use App\Mail\CompteValide;
use App\Mail\CompteRejete;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CompteBancaireController extends Controller
{



    private function genererNumeroCarte()
    {
        return implode('', array_map(fn() => rand(1000, 9999), range(1, 4))); // 16 chiffres
    }

    private function genererCVV()
    {
        return str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
    }

    private function genererDateExpiration()
    {
        return now()->addYears(3)->format('Y-m-d'); // Expire dans 3 ans
    }


    // Afficher le formulaire pour créer un compte bancaire
    public function create()
    {
        return view('compte.create');
    }
    public function confirmation()
    {
        return view('compte.confirmation');
    }

    // Traiter la soumission du formulaire pour créer un compte bancaire
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'type_compte' => 'required|in:courant,epargne',
            'solde' => 'required|numeric|min:0',
        ]);

        // Génération des identifiants du compte bancaire
        $code_banque = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $code_guichet = str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $numero_compte = str_pad(mt_rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
        $cle_controle = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);




        // Création du compte bancaire
        $compte = CompteBancaire::create([
            'user_id' => auth()->id(),
            'type_compte' => $request->type_compte,
            'solde' => $request->solde,
            'code_banque' => $code_banque,
            'code_guichet' => $code_guichet,
            'numero_compte' => $numero_compte,
            'cle_rib' => $cle_controle,
            'statut' => 'en_attente',
            'retraits_mois' => 0, // utile si compte épargne
        ]);

        $compte->numero_carte = $this->genererNumeroCarte();
        $compte->cvv = $this->genererCVV();
        $compte->date_expiration = $this->genererDateExpiration();
        return redirect()->route('dashboard')->with('success', 'Compte créé avec succès');
    }

    public function retrait(Request $request, $compteId)
    {
        // Validation des données
        $request->validate([
            'montant' => 'required|numeric|min:1', // Validation du montant
        ]);

        // Récupérer le compte bancaire
        $compte = CompteBancaire::findOrFail($compteId);

        // Vérifier si le compte est un compte épargne et s'il y a déjà 2 retraits
        if ($compte->type_compte == 'epargne') {
            $retraitsEffectues = Transaction::where('compte_bancaire_id', $compte->id)
                ->where('type', 'retrait')
                ->count();

            if ($retraitsEffectues >= 2) {
                return back()->withErrors('Vous ne pouvez effectuer que 2 retraits par mois pour ce compte épargne.');
            }
        }

        // Vérifier si le solde est suffisant
        if ($compte->solde < $request->montant) {
            return back()->withErrors('Solde insuffisant.');
        }

        // Effectuer le retrait
        $compte->solde -= $request->montant;
        $compte->save();

        // Enregistrer la transaction de retrait
        Transaction::create([
            'compte_bancaire_id' => $compte->id,
            'type' => 'retrait',
            'montant' => $request->montant,
        ]);

        return redirect()->route('compte.show', $compte->id)->with('success', 'Retrait effectué avec succès.');
    }


    public function validerCompte(Request $request, $id)
    {
        // Validation de la justification (si tu souhaites que le gestionnaire fournisse une justification lors de la validation)
        $request->validate([
            'justification' => 'nullable|string|max:255', // La justification est optionnelle ici
        ]);

        // Récupération du compte bancaire
        $compte = CompteBancaire::findOrFail($id);

        // Mise à jour du statut à "actif" et ajout de la justification si présente
        $compte->statut = 'actif';
        if ($request->has('justification')) {
            $compte->justification = $request->justification;
        }
        $compte->save();

        // Envoi d'un e-mail pour informer le client de la validation du compte
        Mail::to($compte->user->email)->send(new CompteValide($compte));

        // Redirection avec un message de succès
        return redirect()->route('compte.validation')->with('success', 'Compte validé avec succès.');
    }


    public function rejeterCompte(Request $request, $id)
    {
        // Validation de la justification
        $request->validate([
            'justification' => 'required|string|max:255',
        ]);

        $compte = CompteBancaire::findOrFail($id);

        // Mise à jour du statut et ajout de la justification
        $compte->statut = 'rejete';
        $compte->justification = $request->justification;
        $compte->save();

        // Envoi d'un e-mail pour informer le client du rejet
        Mail::to($compte->user->email)->send(new CompteRejete($compte));

        return redirect()->route('compte.validation')->with('error', 'Compte rejeté.');
    }


    public function appliquerInterets()
    {
        $user = Auth::user();
        $compte = $user->compteBancaire;

        if ($compte->type_compte === 'epargne') {
            $now = now();

            // Par défaut : on applique les intérêts une fois par an
            if (!$compte->derniere_capitalisation || $compte->derniere_capitalisation->lt($now->copy()->subYear())) {
                $interet = $compte->solde * 0.03;
                $compte->solde += $interet;
                $compte->derniere_capitalisation = $now;
                $compte->save();

                return back()->with('success', 'Intérêts annuels de 3% appliqués avec succès.');
            } else {
                return back()->with('info', 'Les intérêts ont déjà été appliqués cette année.');
            }
        }

        return back()->with('error', 'Ce compte n’est pas un compte épargne.');
    }


}
