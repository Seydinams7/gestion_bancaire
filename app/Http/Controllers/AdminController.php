<?php

namespace App\Http\Controllers;

use App\Models\CompteBancaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompteValide;
use App\Mail\CompteRejete;

class AdminController extends Controller
{
    // afficher toutes les demandes d’ouverture
    public function demandesOuverture()
    {
        $comptes = CompteBancaire::where('statut', 'en_attente')->get();
        return view('admin.ouvertures', compact('comptes'));
    }

// valider une ouverture
    public function validerOuverture($id)
    {
        $compte = CompteBancaire::findOrFail($id);
        $compte->statut = 'actif';
        $compte->save();

        Mail::to($compte->user->email)->send(new CompteValide($compte));
        return back()->with('success', 'Compte validé.');
    }

// rejeter une ouverture
    public function rejeterOuverture($id)
    {
        $compte = CompteBancaire::findOrFail($id);
        $compte->statut = 'rejete';
        $compte->save();

        Mail::to($compte->user->email)->send(new CompteRejete($compte));
        return back()->with('success', 'Compte rejeté.');
    }



    public function demandesFermeture()
    {
        $comptes = CompteBancaire::where('statut', 'en_attente_fermeture')->get();
        return view('admin.fermetures', compact('comptes'));
    }

    public function validerFermeture($id)
    {
        $compte = CompteBancaire::findOrFail($id);
        $compte->statut = 'ferme';
        $compte->save();

        Mail::to($compte->user->email)->send(new CompteFerme($compte));
        return back()->with('success', 'Fermeture validée.');
    }

    public function rejeterFermeture($id)
    {
        $compte = CompteBancaire::findOrFail($id);
        $compte->statut = 'actif';
        $compte->save();

        Mail::to($compte->user->email)->send(new FermetureRejetee($compte));
        return back()->with('success', 'Demande rejetée.');
    }

    public function transactions()
    {
        $transactions = \App\Models\Transaction::with(['compte.user'])->latest()->get();
        return view('admin.transactions', compact('transactions'));
    }


}
