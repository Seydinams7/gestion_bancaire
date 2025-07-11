<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'numero_telephone', 'role',
    ];

    // Relation avec le compte bancaire (un utilisateur a un seul compte)
    public function compteBancaire()
    {
        return $this->hasOne(CompteBancaire::class, 'user_id');
    }
    public function comptes()
    {
        return $this->hasMany(CompteBancaire::class);
    }

}
