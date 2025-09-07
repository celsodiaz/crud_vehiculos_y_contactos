<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'nombre'=> $this->nombre,
            'apellidos'=> $this->apellidos,
            'nroDocumento'=> $this->nro_documento,
            'correo'=> $this->correo,
            'telefono'=> $this->telefono,
            'Vehiculo' => VehiculoResource::collection($this->whenLoaded('vehiculos'))
        ];
    }
}
