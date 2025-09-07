<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ContactoSeeder::class,
            VehiculoSeeder::class,
        ]);

        $this->command->info('✅ Base de datos poblada con seeds correctamente!');
        $this->command->info('📊 Datos creados:');
        $this->command->info('   - Contactos: ' . \App\Models\Contacto::count());
        $this->command->info('   - Vehículos: ' . \App\Models\Vehiculo::count());
    }
}
