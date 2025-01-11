<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Requerimiento;
class Soporte extends Model
{
    /** @use HasFactory<\Database\Factories\SoporteFactory> */
    use HasFactory;

    protected $table = 'soportes';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo'
    ];

    public function requerimiento(){
        return $this->hasMany(Requerimiento::class);
    }
}
