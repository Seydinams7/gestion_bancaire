<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompteBancaire;
use App\Notifications\VirementNotification;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user(); // Récupérer l'utilisateur connecté

            // Vérifier si l'email est vérifié
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice'); // Rediriger vers la page de vérification
            }

            $compte = $user->compteBancaire; // Récupérer le compte bancaire de l'utilisateur
            $transactions = $compte ? $compte->transactions()->latest()->take(5)->get() : []; // Dernières 5 transactions
            // Marquer toutes les notifications comme lues
            auth()->user()->notifications->markAsRead();


            // Récupérer les notifications pour les afficher
            $notifications = auth()->user()->notifications;

            // Passer les données à la vue

                return view('dashboard', compact('user', 'compte', 'transactions', 'notifications'));

        }

        return redirect()->route('login');
    }


}
