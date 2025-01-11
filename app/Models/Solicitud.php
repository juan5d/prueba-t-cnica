<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    /** @use HasFactory<\Database\Factories\SolicitudFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'fecha_ingres',
        'solicitud'
    ];

    public function requerimiento(){
        return $this->hasMany(Requerimiento::class);
    }
}
