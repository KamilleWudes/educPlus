<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matier extends Model
{
    use HasFactory;

    public function bulletin(){
        return $this->belongsToMany(bulletin::class,"bulletin_professeur_typecompositon_matiers","matier_id","bulletin_id");
     }

     public function typeCompositon(){
        return $this->belongsToMany(typeComposition::class,"bulletin_professeur_typecompositon_matiers","matier_id","type_compo_id");
     }
     public function professeur(){
        return $this->belongsToMany(Professeur::class,"bulletin_professeur_typecompositon_matiers","matier_id","professeur_id");
     }


     public function anneeScolaire(){
        return $this->belongsToMany(anneeScolaire::class,"classe_anneescolaire_matieres","matier_id","annee_scolaire_id");
     }

     public function classes(){
        return $this->belongsToMany(classe::class,"classe_anneescolaire_matieres","matier_id","classe_id");
     }

     public function professeurs(){
        return $this->belongsToMany(Professeur::class,"professeur_classe_matieres","matier_id","professeur_id");
     }

     public function classe(){
        return $this->belongsToMany(classe::class,"professeur_classe_matieres","matier_id","classe_id");
     }

     public function ecoles(){
        return $this->belongsTo(Ecole::class,"ecole_id","id");
    }


     protected $fillable = ["nom"];
}
