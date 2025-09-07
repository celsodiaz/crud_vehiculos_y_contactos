<?php

namespace Database\Seeders;

use App\Models\Contacto;
use App\Models\Vehiculo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener contactos existentes
        $contactos = Contacto::all();

        //Verificar primero si generaste el seed de Contacto
        if ($contactos->isEmpty()) {
            $this->command->warn('No hay contactos. Ejecuta ContactoSeeder primero.');
            return;
        }

        //Creacion de 100 vehiculos
        Vehiculo::factory(100)
            ->create([
                'contacto_id' => fn() => $contactos->random()->id
            ]);

        //Algunos contactos con múltiples vehículos    
        $contactos->take(10)->each(function ($contacto) {
            Vehiculo::factory(rand(2, 5))->create([
                'contacto_id' => $contacto->id
            ]);
        });
    }
}
