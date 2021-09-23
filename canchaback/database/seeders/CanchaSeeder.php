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
            'deporte' => 'basket',
            'club_configuracion_id' => '1',
        ]);

        DB::table('canchas')->insert([
            'deporte' => 'futbol',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'deporte' => 'voley',
            'club_configuracion_id' => '3',
        ]);

        DB::table('canchas')->insert([
            'deporte' => 'hockey',
            'club_configuracion_id' => '1',
        ]);

        DB::table('canchas')->insert([
            'deporte' => 'tenis',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'deporte' => 'pingpong',
            'club_configuracion_id' => '3',
        ]);
    }
}
