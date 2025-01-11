<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    /** @use HasFactory<\Database\Factories\RequerimientoFactory> */
    use HasFactory;

    protected $fillable = [
        'solicitud_id',
        'soporte_id',
        'comentario',
        'estado',
        'fecha_solucion'
    ];

    /**
     * Relación con el modelo Solicitud.
     */
    public function solicitud(){
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }

    /**
     * Relación con el modelo Soporte.
     */
    public function soporte(){
        return $this->belongsTo(Soporte::class, 'soporte_id');
    }
}
