<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiculoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'id'=>$this->id,
            'placa'=>$this->placa,
            'marca'=>$this->marca,
            'modelo'=>$this->modelo,
            'fechaFabricacion'=>$this->fecha_fabricacion,
            'contactoId' => $this->contacto_id
        ];
    }
}
