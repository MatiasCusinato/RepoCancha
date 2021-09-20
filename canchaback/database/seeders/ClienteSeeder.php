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

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '5',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '6',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '8',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '10',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '11',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '12',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '13',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '14',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '15',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '16',
            'club_configuracion_id' => '2',
        ]);

        DB::table('cliente_club_configuracion')->insert([
            'cliente_id' => '17',
            'club_configuracion_id' => '2',
        ]);

    }
}
