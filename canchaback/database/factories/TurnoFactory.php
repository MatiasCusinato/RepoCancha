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
            'club_configuracion_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'tipo_turno' => $this->faker->word,
            //'fecha_Desde' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            //'fecha_Hasta' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'fecha_Desde' => "2018-11-21 11:00:00",
            'fecha_Hasta' => "2018-11-21 12:00:00",
            'grupo' => $this->faker->numberBetween($min = 1, $max = 1),
            'precio' => $this->faker->numberBetween($min = 1, $max = 10000),
            'estado' => $this->faker->numberBetween($min = 1, $max = 3),
        ];
    }
}
