<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Turno;
use App\Models\Cliente;
use App\Models\Cancha;
use App\Models\clubConfiguracion;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\clubConfiguracion::factory(3)->create();
        \App\Models\User::factory(3)->create();
        \App\Models\Cancha::factory(15)->create();
        \App\Models\Cliente::factory(20)->create();
        \App\Models\Turno::factory(20)->create();

        $this->call(ClienteSeeder::class);
    }
}
