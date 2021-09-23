<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turnos')->insert([
            'cliente_id' => '1',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'futbol5',
            'fecha_Desde' => '2018-11-19 00:00:00',
            'fecha_Hasta' => '2018-11-19 00:00:00',
            'grupo' => 1,
            'precio' => '500',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '2',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'futbol5 casual',
            'fecha_Desde' => '2018-11-20 00:00:00',
            'fecha_Hasta' => '2018-11-20 00:00:00',
            'grupo' => 2,
            'precio' => '500',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '3',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'entrenamiento',
            'fecha_Desde' => '2018-11-21 00:00:00',
            'fecha_Hasta' => '2018-11-21 00:00:00',
            'grupo' => 3,
            'precio' => '500',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '4',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'cumpleaños',
            'fecha_Desde' => '2018-11-22 00:00:00',
            'fecha_Hasta' => '2018-11-22 00:00:00',
            'grupo' => 4,
            'precio' => '500',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '5',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'entrenamiento',
            'fecha_Desde' => '2018-11-23 00:00:00',
            'fecha_Hasta' => '2018-11-23 00:00:00',
            'grupo' => 5,
            'precio' => '500',
        ]);

    }
}
