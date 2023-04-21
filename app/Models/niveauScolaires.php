<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class niveauScolaires extends Model
{
    use HasFactory;

    public function classe(){
        return $this->hasMany(classe::class);
         }
    protected $fillable = ["nom","ecole_id"];
}

?>
