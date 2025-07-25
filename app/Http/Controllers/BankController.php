<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteBancaire;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\VirementNotification;
use Barryvdh\DomPDF\Facade\Pdf;




use Carbon\Carbon;
use App\Models\Retrait;

class BankController extends Controller
{
    public function exportPDF()
    {
        $user = Auth::user();
        $compte = $user->compteBancaire;

        if (!$compte) {
            return redirect()->back()->withErrors(['pdf' => 'Aucun compte bancaire associé.']);
        }

        $transactions = $compte->transactions()->latest()->get();

        $pdf = Pdf::loadView('pdf.transactions', [
            'transactions' => $transactions,
            'compte' => $compte,
            'user' => $user,
        ]);

        return $pdf->download('historique-transactions.pdf');
    }
    public function showVirementForm()
    {
        $user = auth()->user();
        $comptes = CompteBancaire::where('user_id', '!=', $user->id)->get();
        return view('/compte/virement', compact('comptes'));
    }

    public function submitVirement(Request $request)
    {
        $request->validate([
            'num_compte_destinataire' => 'required|string|exists:compte_bancaires,numero_compte',
            'montant' => 'required|numeric|min:1',
        ]);

        // Récupérer le compte source (celui de l'utilisateur authentifié)
        $compteEmetteur = Auth::user()->compteBancaire;

        // Vérifier si le solde est suffisant
        if ($compteEmetteur->solde < $request->montant) {
            return back()->withErrors(['montant' => 'Fonds insuffisants pour ce virement.']);
        }

        // Récupérer le compte destinataire à partir de son numéro de compte
        $compteDestinataire = CompteBancaire::where('numero_compte', $request->num_compte_destinataire)->first();

        // Démarrer une transaction pour garantir que tout se passe bien
        DB::beginTransaction();

        try {
            // Effectuer le virement en ajustant les soldes des deux comptes
            $compteEmetteur->solde -= $request->montant;
            $compteEmetteur->save();

            $compteDestinataire->solde += $request->montant;
            $compteDestinataire->save();

            // Créer la transaction en utilisant l'ID du compte source et du compte destinataire
            Transaction::create([
                'compte_source_id' => $compteEmetteur->id,
                'compte_dest_id' => $compteDestinataire->id,
                'montant' => $request->montant,
                'type' => 'virement',
                'compte_bancaire_id' => $compteEmetteur->id,
                'user_id' => auth()->user()->id,  // Ajoute l'ID de l'utilisateur
            ]);


            // Commit de la transaction
            DB::commit();
            $compteDestinataire->user->notify(new VirementNotification([
                'montant' => $request->montant,
                'compte_destinataire' => $compteDestinataire->numero_compte,
            ]));
            // Marquer toutes les notifications comme lues
            auth()->user()->notifications->markAsRead();

            return redirect()->route('dashboard')->with('success', 'Virement effectué avec succès!');
        }  catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Une erreur est survenue lors du virement. Détails: ' . $e->getMessage()]);
        }
    }




    public function deposer(Request $request)
    {

        $request->validate([
            'compte_id' => 'required|exists:compte_bancaires,id',
            'montant' => 'required|numeric|min:1',
        ]);

        $compte = CompteBancaire::findOrFail($request->compte_id);

        // Ajout du montant au solde
        $compte->solde += $request->montant;
        $compte->save();
        Transaction::create([
            'compte_bancaire_id' => $compte->id,
            'user_id' => Auth::id(),
            'type' => 'depot',
            'montant' => $request->montant,
        ]);


        return back()->with('success', 'Dépôt effectué avec succès.');
    }


    public function confirmation()
    {
        return view('compte.confirmation');
    }

    public function showDepotForm()
    {
        $comptes = CompteBancaire::where('user_id', Auth::id())->get();
        return view('compte.deposer', compact('comptes'));
    }

    public function showRetraitForm()
    {
        $comptes = CompteBancaire::where('user_id', auth()->user()->id)->get();
        return view('compte.retrait', compact('comptes'));
    }

    public function retrait(Request $request)
    {
        $user = Auth::user();
        $compte = $user->compteBancaire;

        $montant = $request->input('montant');

        // Vérifier que le montant est valide
        if (!is_numeric($montant) || $montant <= 0) {
            return back()->withErrors(['montant' => 'Montant invalide.']);
        }

        // Vérifier que le solde est suffisant
        if ($montant > $compte->solde) {
            return back()->withErrors(['montant' => 'Solde insuffisant.']);
        }

        // Si c'est un compte épargne
        if ($compte->type_compte === 'epargne') {
            $now = now();

            // Vérifie si on est dans un nouveau mois → on reset le compteur
            if (!$compte->dernier_retrait || $compte->dernier_retrait->format('Y-m') !== $now->format('Y-m')) {
                $compte->retraits_mois = 0;
            }

            // Bloque si 2 retraits déjà faits
            if ($compte->retraits_mois >= 2) {
                return back()->withErrors(['retrait' => 'Limite de 2 retraits par mois atteinte pour un compte épargne.']);
            }

            // Incrémenter le compteur
            $compte->retraits_mois += 1;
            $compte->dernier_retrait = $now;
        }

        // Décrémenter le solde
        $compte->solde -= $montant;
        $compte->save();

        // Enregistrer la transaction
        Transaction::create([
            'compte_bancaire_id' => $compte->id,
            'user_id' => Auth::id(),
            'type' => 'retrait',
            'montant' => $montant,
        ]);

        return redirect()->route('dashboard')->with('success', 'Retrait effectué avec succès.');
    }




    public function edit()
    {
        $user = auth()->user(); // Récupérer l'utilisateur authentifié
        return view('compte.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',  // Valider le champ name
            'numero_telephone' => 'required|string|max:15', // Valider le numéro de téléphone
        ]);

        $user = auth()->user();
        $user->name = $request->name;  // Mettre à jour le nom
        $user->numero_telephone = $request->numero_telephone;  // Mettre à jour le numéro de téléphone
        $user->save();  // Sauvegarder les modifications

        return redirect()->route('dashboard')->with('success', 'Informations mises à jour avec succès.'); // Rediriger après la mise à jour
    }


    public function store(Request $request)
    {
        $compte = CompteBancaire::find($request->compte_id);

        // Vérification si le compte est épargne et si la limite de retraits est atteinte
        if (!$compte->peutEffectuerUnRetrait()) {
            return back()->with('error', 'Vous avez dépassé la limite de retraits pour ce mois.');
        }

        // Création du retrait
        $retrait = new Retrait();
        $retrait->compte_id = $compte->id;
        $retrait->montant = $request->montant;
        $retrait->date_retrait = now();
        $retrait->save();

        // Mise à jour du solde du compte
        $compte->solde -= $request->montant;
        $compte->save();

        return back()->with('success', 'Retrait effectué avec succès.');
    }


}
