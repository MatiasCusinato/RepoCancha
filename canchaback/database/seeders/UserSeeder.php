<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('pabloadmin'),
            'club_configuracion_id' => '4',
            'token_actual' => 'null',
            'rol_id' => '2',
        ]);
    }
}