<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_configuracions', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_club");
            $table->string("razon_social");
            $table->string("ubicacion");
            $table->string("contacto");
            $table->integer("ultimo_grupo");
            $table->integer("cuit");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_configuracions');
    }
}
