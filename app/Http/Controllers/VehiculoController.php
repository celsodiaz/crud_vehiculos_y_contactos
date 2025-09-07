<?php

namespace App\Http\Controllers;

use App\Filters\VehiculoFilter;
use App\Models\Vehiculo;
use App\Http\Requests\StoreVehiculoRequest;
use App\Http\Requests\UpdateVehiculoRequest;
use App\Http\Resources\VehiculoCollection;
use App\Http\Resources\VehiculoResource;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Crear instancia del filtro
        $filter = new VehiculoFilter();
        $queryItems = $filter->transform($request);

        $vehiculosQuery = Vehiculo::with('contacto');

        // Aplicar filtros si existen
        if (!empty($queryItems)) {
            foreach ($queryItems as $queryItem) {
                [$column, $operator, $value] = $queryItem;

                // Manejar filtros especiales relacionados con contacto
                if (in_array($column, ['clienteNombre', 'clienteDocumento'])) {
                    $vehiculosQuery->whereHas('contacto', function ($query) use ($column, $operator, $value) {
                        $contactoColumn = match($column) {
                            'clienteNombre' => 'nombre',
                            'clienteDocumento' => 'nro_documento',
                            default => $column
                        };
                        $query->where($contactoColumn, $operator, $value);
                    });
                    continue;
                }

                // Aplicar filtros normales del vehículo
                $vehiculosQuery->where($column, $operator, $value);
            }
        }

        // Paginación
        $perPage = $request->query('per_page', 15);
        $vehiculos = $vehiculosQuery->paginate($perPage);

        return new VehiculoCollection($vehiculos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehiculoRequest $request)
    {
        $vehiculo = Vehiculo::create($request->validated());
        return new VehiculoResource($vehiculo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehiculo $vehiculo)
    {
        return new VehiculoResource($vehiculo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehiculoRequest $request, Vehiculo $vehiculo)
    {
         $vehiculo->update($request->validated());
        return response()->json([
            'message' => 'Contacto actualizado correctamente',
            'data' => $vehiculo
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        //
    }
}
