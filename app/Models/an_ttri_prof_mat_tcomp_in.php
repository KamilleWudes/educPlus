<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class an_ttri_prof_mat_tcomp_in extends Model
{
    use HasFactory;

    protected $fillable = ["type_compo_id","professeur_id","classe_id","matier_id","annee_scolaire_id","inscription_id","type_trimestre_id","note"];
}
