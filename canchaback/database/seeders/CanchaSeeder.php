<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CanchaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('canchas')->insert([
            'club_configuracion_id' => '1',
            'deporte' => 'futbol',
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'hockey',

        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'Entrenamiento',
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '1',
            'deporte' => 'futbol',
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'EscuelaFC',
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'hockey',
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'handball',
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'Entrenamiento'
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'basquet',
        ]);

        DB::table('canchas')->insert([
            'club_configuracion_id' => '2',
            'deporte' => 'tenis',
        ]);
    }
}
