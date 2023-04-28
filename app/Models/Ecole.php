<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matier;


class Ecole extends Model
{
    use HasFactory;

    public function niveauScolaires(){
        return $this->hasMany(niveauScolaires::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }

    public function prof(){
        return $this->hasMany(Professeur::class);
    }

    public function mat(){
        return $this->hasMany(Matier::class);
    }

    protected $fillable = ["nom","adresse","email","telephone1","telephone2"];


}
?>
