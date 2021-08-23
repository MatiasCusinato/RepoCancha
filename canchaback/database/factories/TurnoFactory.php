<?php

namespace Database\Factories;

use App\Models\Turno;
use Illuminate\Database\Eloquent\Factories\Factory;

class TurnoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Turno::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cliente_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'cancha_id'  => $this->faker->numberBetween($min = 1, $max = 5),
            'tipo_turno' => $this->faker->numberBetween($min = 1, $max = 4),
            'fecha_Desde' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'fecha_Hasta' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'precio' => $this->faker->numberBetween($min = 1, $max = 3),
        ];
    }
}
