<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion 1 a M
    public function users() 
    {
        return $this->hasMany('App\Models\User');
    }
}
