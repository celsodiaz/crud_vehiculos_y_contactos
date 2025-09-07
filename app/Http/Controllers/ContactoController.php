<?php

namespace App\Http\Controllers;

use App\Filters\ContactoFilter;
use App\Models\Contacto;
use App\Http\Requests\StoreContactoRequest;
use App\Http\Requests\UpdateContactoRequest;
use App\Http\Resources\ContactoCollection;
use App\Http\Resources\ContactoResource;
use Illuminate\Http\Request;
use PDO;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Crear instancia del filtro
        $filter = new ContactoFilter();
        $queryItems = $filter->transform($request);

        $contactosQuery = Contacto::query();

        // Aplicar filtros si existen
        if (!empty($queryItems)) {
            foreach ($queryItems as $queryItem) {
                [$column, $operator, $value] = $queryItem;
                $contactosQuery->where($column, $operator, $value);
            }
        }

        // Incluir vehículos si se solicita
        if ($request->query('includeVehiculos') === 'true') {
            $contactosQuery->with('vehiculos');
        }

        // Paginación
        $perPage = $request->query('per_page', 15); 
        $contactos = $contactosQuery->paginate($perPage);
        
        // Retornar con Resource Collection
        return new ContactoCollection($contactos);
    
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
    public function store(StoreContactoRequest $request)
    {
        $contacto = Contacto::create($request->validated());
        return new ContactoResource($contacto);
    }


    /**
     * Display the specified resource.
     */
    public function show(Contacto $contacto)
    {
        $includeVehiculos = request()->query('includeVehiculos');
        if($includeVehiculos){
            return new ContactoResource($contacto->loadMissing('vehiculos'));
        }
        return new ContactoResource($contacto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contacto $contacto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactoRequest $request, Contacto $contacto)
    {
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacto $contacto)
    {
        //
    }
}
