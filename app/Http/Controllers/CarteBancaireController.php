<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CarteBancaireController extends Controller
{
    public function genererCarte()
    {
        $user = auth()->user();
        $compte = $user->compteBancaire;

        if (!$compte) {
            return redirect()->back()->with('error', 'Aucun compte trouvé.');
        }

        // Génère les infos manquantes
        if (empty($compte->numero_carte)) {
            $compte->numero_carte = implode(' ', [
                rand(1000, 9999),
                rand(1000, 9999),
                rand(1000, 9999),
                rand(1000, 9999)
            ]);
        }

        if (empty($compte->cvv)) {
            $compte->cvv = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        }

        if (empty($compte->date_expiration)) {
            $compte->date_expiration = now()->addYears(3)->format('Y-m-d');
        }

        $compte->save();

        $pdf = PDF::loadView('pdf.carte', compact('user', 'compte'));
        return $pdf->download('carte_bancaire.pdf');
    }

    }
