<?php

namespace Database\Factories;

use App\Models\Cancha;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanchaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cancha::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'club_configuracion_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'deporte'=> $this->faker->word,
        ];
    }
}
