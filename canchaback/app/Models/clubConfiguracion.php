<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clubConfiguracion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_club',
        'razon_social',
        'ubicacion',
        'contacto',
        'ultimo_grupo',
        'cuit',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion 1 A M 
    public function turnos()
    {
        return $this->hasMany('App\Models\Turno');
    }

    //Relacion 1 A M 
    public function canchas()
    {
        return $this->hasMany('App\Models\Cancha');
    }

    //Relacion 1 a 1 INVERSA
    public function users() 
    {
        return $this->belongsToMany('App\Models\User');
    }

    //Relacion M A M 
    public function clientes()
    {
        return $this->belongsToMany('App\Models\Cliente');
    }
}
