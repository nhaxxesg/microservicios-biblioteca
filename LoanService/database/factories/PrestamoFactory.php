<?php

namespace Database\Factories;

use App\Models\Prestamo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prestamo>
 */
class PrestamoFactory extends Factory
{
    protected $model = Prestamo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaPrestamo = $this->faker->dateTimeBetween('-30 days', 'now');
        $fechaDevolucionPrevista = clone $fechaPrestamo;
        $fechaDevolucionPrevista->modify('+15 days');
        
        return [
            'libro_id' => $this->faker->numberBetween(1, 100),
            'user_id' => User::factory(),
            'sancion_id' => null,
            'fecha_prestamo' => $fechaPrestamo,
            'fecha_devolucion_prevista' => $fechaDevolucionPrevista,
            'fecha_devolucion_real' => null,
            'estado' => $this->faker->randomElement(array_values(Prestamo::ESTADOS())),
        ];
    }

    public function activo()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => Prestamo::ESTADOS()['ACTIVO'],
                'fecha_devolucion_real' => null,
            ];
        });
    }

    public function devuelto()
    {
        return $this->state(function (array $attributes) {
            $fechaDevolucion = clone $attributes['fecha_prestamo'];
            $fechaDevolucion->modify('+' . $this->faker->numberBetween(1, 14) . ' days');
            
            return [
                'estado' => Prestamo::ESTADOS()['DEVUELTO'],
                'fecha_devolucion_real' => $fechaDevolucion,
            ];
        });
    }

    public function retrasado()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => Prestamo::ESTADOS()['RETRASADO'],
                'fecha_devolucion_prevista' => now()->subDays(5),
                'fecha_devolucion_real' => null,
            ];
        });
    }
}
