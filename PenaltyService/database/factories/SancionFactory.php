<?php

namespace Database\Factories;

use App\Models\Sancion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SancionFactory extends Factory
{
    protected $model = Sancion::class;

    public function definition(): array
    {
        $fecha_inicio = $this->faker->dateTimeBetween('-1 year', '+1 month');
        $fecha_fin = $this->faker->dateTimeBetween($fecha_inicio, '+1 year');

        return [
            'usuario_id' => User::factory(),
            'motivo' => $this->faker->sentence(),
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'estado' => $this->faker->randomElement(['activa', 'cumplida', 'cancelada', 'apelada'])
        ];
    }

    public function activa()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'activa',
                'fecha_inicio' => now()->subDay(),
                'fecha_fin' => now()->addMonth()
            ];
        });
    }
}
