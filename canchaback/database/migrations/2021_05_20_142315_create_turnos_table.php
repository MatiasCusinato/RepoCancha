<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("cliente_id")->nullable();
            $table->foreign('cliente_id')
                    ->references('id')->on('clientes')
                    ->onDelete('set null');

            $table->unsignedBigInteger("cancha_id")->nullable();        
            $table->foreign('cancha_id')
                    ->references('id')->on('canchas')
                    ->onDelete('set null');

            $table->unsignedBigInteger("club_configuracion_id")->nullable();
            $table->foreign('club_configuracion_id')
                    ->references('id')->on('club_configuracions')
                    ->onDelete('set null');
                    
            $table->string('tipo_turno',30);
            $table->dateTime("fecha_Desde");
            $table->dateTime("fecha_Hasta");
            $table->integer("grupo");
            $table->integer('precio');   
            $table->enum('estado', ['Reservado', 'Cobrado', 'Adeudado']);   

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
        Schema::dropIfExists('turnos');
    }
}
