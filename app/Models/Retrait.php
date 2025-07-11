<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retrait extends Model
{
    use HasFactory;

    protected $table = 'retraits';

    protected $fillable = ['compte_id', 'montant', 'date_retrait'];

    public function compte()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_id');
    }
}
