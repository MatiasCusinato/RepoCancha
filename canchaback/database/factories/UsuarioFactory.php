<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker-> freeEmail,
            'password' => $this->faker->password,
            'telefono' => $this->faker->ean8,
            'club_configuracion_id' => $this->faker->numberBetween($min = 1, $max = 3),
        ];
    }
}
