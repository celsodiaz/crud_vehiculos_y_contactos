<?php

namespace Database\Seeders;

use App\Models\Contacto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contacto::factory(50)->create();
        Contacto::factory()->create([
            'nombre' => 'Juan Carlos',
            'apellidos' => 'Pérez García',
            'nro_documento' => 'DNI12345678',
            'correo' => 'juan.carlos@demo.com',
            'telefono' => '987654321',
        ]);
    }
}
