<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    /** @use HasFactory<\Database\Factories\ContactoFactory> */
    use HasFactory;

    protected $fillable = ['nombre','apellidos','nro_documento','correo','telefono'];
    
    /**
     * Get all of the Vehiculos for the Contacto
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }
}
