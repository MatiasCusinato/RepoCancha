<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nombre' => 'Pablo',
            'apellido' => 'Schumans',
            'email' => 'pablo@gmail.com',
            'telefono' => '3446 435678',
            'password' => 'pabloadmin',
            'club_configuracion_id' => '4',
            'token_actual' => 'null',
        ]);
    }
}
