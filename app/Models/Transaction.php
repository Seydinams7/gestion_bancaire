<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['compte_bancaire_id', 'compte_source_id', 'compte_dest_id', 'user_id', 'type', 'montant'];

    public function compte()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_bancaire_id');
    }
    // Dans le modèle Transaction
    public function compteSource()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_source_id');
    }

    public function compteDest()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_dest_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
