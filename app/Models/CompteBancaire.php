<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteBancaire extends Model
{

    use HasFactory;

    protected $dates = ['dernier_retrait', 'derniere_capitalisation'];

    protected $casts = [
        'dernier_retrait' => 'datetime',
    ];

    protected $fillable = [
        'user_id', 'type_compte', 'solde', 'numero_compte', 'code_guichet', 'cle_rib', 'raison_rejet', 'raison_rejet_fermeture'
    ];



    // Calcul des intérêts pour un compte épargne
    public function calculerInterets()
    {
        if ($this->type_compte == 'epargne') {
            $taux = 0.03; // Taux d'intérêt 3% par an
            $interets = $this->solde * $taux;
            return $interets;
        }
        return 0;
    }

    // Vérification de la limite de retraits pour un compte épargne
    public function peutEffectuerUnRetrait()
    {
        if ($this->type_compte == 'epargne') {
            $retraitsMois = Retrait::where('compte_id', $this->id)
                ->whereMonth('date_retrait', now()->month)
                ->count();
            return $retraitsMois < 2; // Si moins de 2 retraits
        }
        return true; // Pas de limite pour les comptes courants
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'compte_bancaire_id');
    }

    public function retraits()
    {
        return $this->hasMany(Retrait::class, 'compte_id');
    }

}

