<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bulletin extends Model
{
    use HasFactory;

    public function anneeScolaire(){
        return $this->belongsTo(anneeScolaire::class,"annee_scolaire_id","id");
    }

    public function type_trimestre(){
        return $this->belongsTo(typeTrimestre::class,"type_trimestre_id","id");
    }
    public function inscription(){
        return $this->belongsTo(inscription::class,"inscription_id","id");
    }


    public function professeur(){
        return $this->belongsToMany(Professeur::class,"bulletin_professeur_typecompositon_matiers","bulletin_id","professeur_id");
     }

     public function matiere(){
        return $this->belongsToMany(Matier::class,"bulletin_professeur_typecompositon_matiers","bulletin_id","matier_id");
     }
     public function typeComposition(){
        return $this->belongsToMany(typeComposition::class,"bulletin_professeur_typecompositon_matiers","bulletin_id","type_compo_id");
     }


}
