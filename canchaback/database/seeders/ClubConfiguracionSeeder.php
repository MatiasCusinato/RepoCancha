<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('club_configuracions')->insert([
            'nombre_club' => 'Independiente',
            'razon_social' => 'Club Rojo de Avellaneda',
            'ubicacion' => 'Ayacucho 299',
            'contacto' => '3446 314626',
            'ultimo_grupo' => '1',
            'cuit' => '2030490576',
        ]);
    }
}
