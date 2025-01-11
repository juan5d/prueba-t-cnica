<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequerimientoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'solicitud_id' => $this->solicitud_id,
            'soporte_id' => $this->soporte_id,
            'comentario' => $this->comentario,
            'estado' => $this->estado,
            'fecha_solucion' => $this->fecha_solucion
        ];
    }
}
