<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '1',
            'club_configuracion_id' => '1',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '2',
            'club_configuracion_id' => '1',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '3',
            'club_configuracion_id' => '1',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '2',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '1',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '4',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '5',
            'club_configuracion_id' => '3',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '6',
            'club_configuracion_id' => '3',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '7',
            'club_configuracion_id' => '3',
        ]);

    }
}
