<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    use HasFactory;

    protected $fillable = [
        'deporte',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function turnos() 
    {
        return $this->hasMany('App\Models\Turno');
    }
}
