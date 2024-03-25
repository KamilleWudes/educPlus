<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class userprincipal extends Model
{
    use HasFactory, Notifiable ;
    protected $fillable = [
        'nom', 'prenom','telephone',
        'email',
        'password'
    ];
}
