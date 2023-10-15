<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeTrimestre extends Model
{
    use HasFactory;

    public function bulletin(){
        return $this->hasMany(bulletin::class);
    }

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    protected $fillable = ["nom","ecole_id"];

}
