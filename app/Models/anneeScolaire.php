<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anneeScolaire extends Model
{
    use HasFactory;

    public function inscription(){
        return $this->hasMany(inscription::class);
    }

    public function bulletin(){
        return $this->hasMany(bulletin::class);
    }


    // public function matiere(){
    //     return $this->belongsToMany(Matier::class,"classe_anneescolaire_matiere","annee_scolaire_id","classe_id","matier_id");
    //  }

    public function matiere(){
        return $this->belongsToMany(Matier::class,"classe_anneescolaire_matiere","annee_scolaire_id","matier_id");
     }

     public function classes(){
        return $this->belongsToMany(classe::class,"classe_anneescolaire_matiere","annee_scolaire_id","classe_id");
     }


    //  public function classes(){
    //     return $this->belongsToMany(classe::class,"classe_anneescolaire_matiere","annee_scolaire_id","classe_id","matier_id");
    //  }

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }


    public function getNextYear()
    {
        $currentYear = date('Y');
        $nextYear = $currentYear + 1;
        return [
            'annee1' => "$currentYear-$nextYear",
            'annee2' => "$nextYear-" . ($nextYear + 1),
        ];
    }

}
