<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class an_ttri_prof_mat_tcomp_in extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ["type_compo_id","professeur_id","classe_id","matier_id","annee_scolaire_id","inscription_id","type_trimestre_id","note"];

    public function typeComposition()
    {
        return $this->belongsTo(TypeComposition::class, 'type_compo_id');
    }
    
    public function professeur()
    {
        return $this->belongsTo(Professeur::class, 'professeur_id');
    }

    public function classe()
{
    return $this->belongsTo(classe::class, 'classe_id');
}

public function matiere()
{
    return $this->belongsTo(Matier::class, 'matier_id');
}

public function anneeScolaire()
{
    return $this->belongsTo(anneeScolaire::class, 'annee_scolaire_id');
}

public function typeTrimestre()
{
    return $this->belongsTo(typeTrimestre::class, 'type_trimestre_id');
}

public function inscription()
{
    return $this->belongsTo(inscription::class, 'inscription_id');
}
public function etudiant(){
    return $this->belongsTo(Etudiant::class,"etudiant_id","id");
}

public function ecole(){
    return $this->belongsTo(Ecole::class,"ecole_id","id");
}

public function niveauScolaire(){
    return $this->belongsTo(niveauScolaires::class,"niveau_scolaires_id","id");
}



}

