<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseAnneescolaireMatiere extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom",
        "annee_scolaire_id",
        "classe_id",
        "matier_id",
        "coefficient"
    ];
}
