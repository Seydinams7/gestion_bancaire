<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeValidation extends Model
{
    public function compte() {
        return $this->belongsTo(Compte::class);
    }

}
