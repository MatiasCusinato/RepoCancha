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

    //Relacion 1 a 1 INVERSA
    public function usuario() 
    {
        return $this->hasOne('App\Models\Usuario');
    }
}
