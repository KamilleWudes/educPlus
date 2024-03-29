<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;

    public function bulletin(){
        return $this->belongsToMany(bulletin::class,"bulletin_professeur_typecompositon_matiers","professeur_id","bulletin_id");
     }

     public function matiere(){
        return $this->belongsToMany(Matier::class,"bulletin_professeur_typecompositon_matiers","professeur_id","matier_id");
     }
     public function typeComposition(){
        return $this->belongsToMany(typeComposition::class,"bulletin_professeur_typecompositon_matiers","professeur_id","type_compo_id");
     }


     public function classe(){
        return $this->belongsToMany(classe::class,"professeur_classe_matieres","professeur_id","classe_id");
     }

     public function matieres(){
        return $this->belongsToMany(Matier::class,"professeur_classe_matieres","professeur_id","matier_id");
     }

     public function ecoles(){
        return $this->belongsTo(Ecole::class,"ecole_id","id");
    }

     protected $fillable = ["nom","prenom","sexe","adresse","email","telephone1","image"];

}
