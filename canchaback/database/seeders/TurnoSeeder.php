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
            'fecha_Desde' => '2018-11-19 10:00:00',
            'fecha_Hasta' => '2018-11-19 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Reservado',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '2',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'futbol5 casual',
            'fecha_Desde' => '2018-11-20 10:00:00',
            'fecha_Hasta' => '2018-11-20 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Reservado',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '3',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'entrenamiento',
            'fecha_Desde' => '2018-11-21 10:00:00',
            'fecha_Hasta' => '2018-11-21 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Cobrado',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '4',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'cumpleaños',
            'fecha_Desde' => '2018-11-22 10:00:00',
            'fecha_Hasta' => '2018-11-22 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Reservado',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '5',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'entrenamiento',
            'fecha_Desde' => '2018-11-23 10:00:00',
            'fecha_Hasta' => '2018-11-23 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Reservado',
        ]);
        DB::table('turnos')->insert([
            'cliente_id' => '5',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'entrenamiento',
            'fecha_Desde' => '2018-11-24 10:00:00',
            'fecha_Hasta' => '2018-11-24 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Cobrado',
        ]);
        DB::table('turnos')->insert([
            'cliente_id' => '5',
            'cancha_id' => '1',
            'club_configuracion_id' => '2',
            'tipo_turno' => 'entrenamiento',
            'fecha_Desde' => '2018-11-25 10:00:00',
            'fecha_Hasta' => '2018-11-25 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Cobrado',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '17',
            'cancha_id' => '26',
            'club_configuracion_id' => '4',
            'tipo_turno' => 'Reservado',
            'fecha_Desde' => '2021-11-17 10:00:00',
            'fecha_Hasta' => '2021-11-17 11:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Reservado',
        ]);

        DB::table('turnos')->insert([
            'cliente_id' => '16',
            'cancha_id' => '26',
            'club_configuracion_id' => '4',
            'tipo_turno' => 'Cobrado',
            'fecha_Desde' => '2021-11-18 11:00:00',
            'fecha_Hasta' => '2021-11-18 12:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Cobrado',
        ]);
        
        DB::table('turnos')->insert([
            'cliente_id' => '15',
            'cancha_id' => '26',
            'club_configuracion_id' => '4',
            'tipo_turno' => 'Adeudado',
            'fecha_Desde' => '2021-11-19 12:00:00',
            'fecha_Hasta' => '2021-11-19 13:00:00',
            'grupo' => 1,
            'precio' => '500',
            'estado' => 'Adeudado',
        ]);

    }
}
