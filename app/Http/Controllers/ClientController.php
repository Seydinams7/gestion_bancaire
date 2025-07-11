<?php

namespace App\Http\Controllers;

use App\Models\CompteBancaire;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    // Tableau de bord du client
    public function dashboard()
    {
        $comptes = CompteBancaire::where('user_id', Auth::id())->get();
        return view('client.dashboard', compact('comptes'));
    }

    // Afficher un compte spécifique
    public function voirCompte($id)
    {
        $compte = CompteBancaire::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $transactions = Transaction::where('compte_bancaire_id', $compte->id)->latest()->get();

        return view('client.compte', compact('compte', 'transactions'));
    }

    // Dépôt d'argent
    public function depot(Request $request, $id)
    {
        $compte = CompteBancaire::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'montant' => 'required|numeric|min:100',
        ]);

        $compte->solde += $request->montant;
        $compte->save();

        Transaction::create([
            'compte_bancaire_id' => $compte->id,
            'type' => 'depot',
            'montant' => $request->montant,
        ]);

        return back()->with('success', 'Dépôt effectué avec succès.');
    }

    // Retrait d'argent
    public function retrait(Request $request, $id)
    {
        $compte = CompteBancaire::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'montant' => 'required|numeric|min:100',
        ]);

        if ($compte->solde < $request->montant) {
            return back()->with('error', 'Solde insuffisant.');
        }

        // Limite de 2 retraits/mois pour compte épargne
        if ($compte->type === 'epargne') {
            $retraitsMois = Transaction::where('compte_bancaire_id', $compte->id)
                ->where('type', 'retrait')
                ->whereMonth('created_at', now()->month)
                ->count();

            if ($retraitsMois >= 2) {
                return back()->with('error', 'Limite de retraits atteinte pour ce mois.');
            }
        }

        $compte->solde -= $request->montant;
        $compte->save();

        Transaction::create([
            'compte_bancaire_id' => $compte->id,
            'type' => 'retrait',
            'montant' => $request->montant,
        ]);

        return back()->with('success', 'Retrait effectué avec succès.');
    }

    // Demande de fermeture de compte
    public function demanderFermeture($id)
    {
        $compte = CompteBancaire::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($compte->statut !== 'actif') {
            return back()->with('error', 'Ce compte ne peut pas être fermé.');
        }

        $compte->statut = 'en_attente_fermeture';
        $compte->save();

        return back()->with('success', 'Demande de fermeture envoyée au gestionnaire.');
    }
}
