<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe extends Model
{
    use HasFactory;

    public function inscription(){
        return $this->hasMany(inscription::class);
    }

    public function ecole(){
        return $this->belongsTo(Ecole::class,"ecole_id","id");
    }

    public function niveauScolaire(){
        return $this->belongsTo(niveauScolaires::class,"niveau_scolaires_id","id");
    }

     public function matiere(){
        return $this->belongsToMany(Matier::class,"classe_anneescolaire_matieres","classe_id","matier_id");
     }

     public function anneeScolaire(){
        return $this->belongsToMany(anneeScolaire::class,"classe_anneescolaire_matieres","classe_id","annee_scolaire_id");
     }

     public function professeur(){
        return $this->belongsToMany(Professeur::class,"professeur_classe_matieres","classe_id","professeur_id");
     }

     public function matieres(){
        return $this->belongsToMany(Matier::class,"professeur_classe_matieres","classe_id","matier_id");
     }

     protected $fillable = ["nom","ecole_id","niveau_scolaires_id"];

}
