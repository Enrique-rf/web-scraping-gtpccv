<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = [
        'vehiculo_id',
        'nombre',
        'matricula',
        'km_inicial',
        'km_real',
        'km_recorridos'
    ];
}
