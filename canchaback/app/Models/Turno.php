<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'cancha_id',
        'club_configuracion_id',
        'tipo_turno',
        'fecha_Desde',
        'fecha_Hasta',
        'grupo',
        'precio',
        'estado',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion 1 a M INVERSA
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

    //Relacion 1 a M INVERSA
    public function cancha() 
    {
        return $this->belongsTo('App\Models\Cancha');
    }

    //Relacion 1 a M INVERSA
    public function club_configuracion() 
    {
        return $this->belongsTo('App\Models\clubConfiguracion');
    }
}
