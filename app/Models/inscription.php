<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inscription extends Model
{
    use HasFactory;
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


}
