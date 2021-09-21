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
            'id' => '1',
            'club_configuracion_id' => '1',
        ]);

        DB::table('canchas')->insert([
            'id' => '2',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'id' => '3',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'id' => '4',
            'club_configuracion_id' => '1',
        ]);

        DB::table('cnahcas')->insert([
            'id' => '5',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'id' => '6',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'id' => '7',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'id' => '8',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'id' => '9',
            'club_configuracion_id' => '2',
        ]);

        DB::table('canchas')->insert([
            'id' => '10',
            'club_configuracion_id' => '2',
        ]);
    }
}
