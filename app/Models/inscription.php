<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Notifications\Notifiable;


class inscription extends Model
{
    use HasFactory, Notifiable;
    use softDeletes;

    public function bulletin(){
        return $this->hasMany(bulletin::class);
    }

    public function etudiant(){
        return $this->belongsTo(Etudiant::class,"etudiant_id","id");
    }

    public function classe(){
        return $this->belongsTo(classe::class,"classe_id","id");
    }

    public function AnneeScolaires(){
        return $this->belongsTo(anneeScolaire::class,"annee_scolaire_id","id");
    }

    public function tuteur(){
        return $this->belongsTo(Tuteur::class,"tuteur_id","id");
    }

    public function ecoles(){
        return $this->belongsTo(Ecole::class,"ecole_id","id");
    }


}
