<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_configuracion_id',
        'deporte',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion 1 a M
    public function turnos() 
    {
        return $this->hasMany('App\Models\Turno');
    }

    //Relacion 1 a M INVERSA
    public function club() 
    {
        return $this->belongsTo('App\Models\clubConfiguracion');
    }
}
