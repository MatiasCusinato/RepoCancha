<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'telefono',
        'club_configuracion_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion 1 a 1 
    public function club_configuracion() 
    {
        return $this->belongsTo('App\Models\clubConfiguracion');
    }
}
