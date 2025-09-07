<?php

namespace Database\Factories;
use App\Models\Contacto;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiculo>
 */
class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Marcas y modelos realistas
        $marcasModelos = [
            'Toyota' => ['Corolla', 'Camry', 'Yaris', 'RAV4', 'Hilux'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'HR-V', 'City'],
            'Nissan' => ['Sentra', 'Altima', 'X-Trail', 'Kicks', 'March'],
            'Hyundai' => ['Elantra', 'Tucson', 'Accent', 'Santa Fe', 'i10'],
            'Chevrolet' => ['Cruze', 'Spark', 'Onix', 'Tracker', 'Tahoe'],
            'Volkswagen' => ['Jetta', 'Golf', 'Tiguan', 'Polo', 'Passat'],
            'Ford' => ['Focus', 'Escape', 'Explorer', 'F-150', 'EcoSport'],
            'Kia' => ['Rio', 'Cerato', 'Sportage', 'Sorento', 'Picanto'],
            'BMW' => ['Serie 3', 'Serie 5', 'X3', 'X5'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLC', 'GLE'],
            'Audi' => ['A3', 'A4', 'Q3', 'Q5'],
            'Lexus' => ['IS', 'ES', 'RX', 'NX'],
        ];

        $marca = $this->faker->randomElement(array_keys($marcasModelos));
        $modelo = $this->faker->randomElement($marcasModelos[$marca]);

        // Generar placa peruana: ABC-123 o AB-1234
        $formatoPlaca = $this->faker->randomElement(['old', 'new']);
        $placa = $formatoPlaca === 'old' 
            ? $this->faker->lexify('???') . '-' . $this->faker->numerify('###')
            : $this->faker->lexify('??') . '-' . $this->faker->numerify('####');

        return [
            'placa' => strtoupper($placa),
            'marca' => $marca,
            'modelo' => $modelo,
            'fecha_fabricacion' => $this->faker->numberBetween(2010, 2024),
            'contacto_id' => Contacto::factory(), // Crea contacto automáticamente
        ];
    }
}
