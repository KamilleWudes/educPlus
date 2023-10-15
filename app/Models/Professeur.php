<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Professeur extends Model
{
    use HasFactory, Notifiable;

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

   //   public function ecoles(){
   //      return $this->belongsTo(Ecole::class,"ecole_id","id");
   //  }

   public function ecoles()
    {
        return $this->belongsToMany(Ecole::class, 'professeur_classe_matieres', 'professeur_id', 'ecole_id');
    }

    public function anneesScolaires()
    {
        return $this->belongsToMany(anneeScolaire::class, 'professeur_classe_matieres', 'professeur_id', 'annee_scolaire_id');
    }

     protected $fillable = ["nom","prenom","sexe","adresse","email","telephone1","image","password"];

}
