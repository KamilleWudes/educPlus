<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tuteur extends Model
{
    use HasFactory, Notifiable;

    public function inscription(){
        return $this->hasMany(inscription::class, 'tuteur_id', 'id');
    }
}
