<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteClubConfiguracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_club_configuracion', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("cliente_id")->nullable();
            $table->foreign('cliente_id')
                    ->references('id')->on('club_configuracions')
                    ->onDelete('set null');

            $table->unsignedBigInteger("club_configuracion_id")->nullable();
            $table->foreign('club_configuracion_id')
                    ->references('id')->on('club_configuracions')
                    ->onDelete('set null');

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
        Schema::dropIfExists('cliente_club_configuracion');
    }
}
