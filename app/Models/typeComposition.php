<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeComposition extends Model
{
    use HasFactory;

    public function bulletin(){
        return $this->belongsToMany(bulletin::class,"bulletin_professeur_typecompositon_matiers","type_compo_id","bulletin_id");
     }

     public function matiere(){
        return $this->belongsToMany(Matier::class,"bulletin_professeur_typecompositon_matiers","type_compo_id","matier_id");
     }
     public function professeur(){
        return $this->belongsToMany(Professeur::class,"bulletin_professeur_typecompositon_matiers","type_compo_id","professeur_id");
     }

     protected $fillable = ["nom","ecole_id"];

}
