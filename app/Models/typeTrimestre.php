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
    protected $fillable = ["nom","ecole_id"];

}
