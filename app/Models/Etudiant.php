<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Notifications\Notifiable;


class Etudiant extends Model
{
    use HasFactory, Notifiable;
    use softDeletes;

    public function inscription(){
        return $this->hasMany(inscription::class);
    }
    protected $fillable = [
    "nom",
    "prenom",
    "sexe",
    "dateNaissance",
    "LieuNaissance",
    "adresse",
    "email",
    "telephone",
    "image"
];

}
