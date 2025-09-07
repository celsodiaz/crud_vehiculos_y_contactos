<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactoCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($contacto) {
                $data = [
                    'id' => $contacto->id,
                    'nombre' => $contacto->nombre,
                    'apellidos' => $contacto->apellidos,
                    'nro_documento' => $contacto->nro_documento,
                    'correo' => $contacto->correo,
                    'telefono' => $contacto->telefono,
                ];

                // Solo incluir vehículos si fueron cargados
                if ($contacto->relationLoaded('vehiculos')) {
                    $data['vehiculos'] = $contacto->vehiculos;
                }

                return $data;
            }),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),

            ]
        ];
    }
}
