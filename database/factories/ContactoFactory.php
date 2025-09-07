<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contacto>
 */
class ContactoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipoDoc = $this->faker->randomElement(['DNI', 'CE', 'PASAPORTE']);
        
        // Genera número de documento según el tipo
        $nroDocumento = match($tipoDoc) {
            'DNI' => $this->faker->numerify('########'), // 8 dígitos
            'CE' => $this->faker->numerify('#########'), // 9 dígitos  
            'PASAPORTE' => $this->faker->bothify('??######'), // 2 letras + 6 números
            default => $this->faker->numerify('########')
        };

        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'nro_documento' => $tipoDoc . $nroDocumento, // Ej: DNI12345678
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->randomElement(['9', '8']) . $this->faker->numerify('#######'), // Formato peruano
        ];
    }
}
