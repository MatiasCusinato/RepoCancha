<?php

namespace Database\Factories;

use App\Models\clubConfiguracion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClubConfiguracionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = clubConfiguracion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre_club' => $this->faker->firstNameMale,
            'razon_social' => $this->faker->firstNameMale,
            'ubicacion' => $this->faker->streetAddress,
            'contacto' => $this->faker->phoneNumber,
            'ultimo_grupo' => $this->faker->numberBetween($min = 1, $max = 50),
            'cuit' => $this->faker->ean8,
        ];
    }
}
