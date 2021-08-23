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
                    
            $table->enum('tipo_turno', ['Escuelaf5','Entrenamiento','Futbol5','Cumpleaños']);
            $table->dateTime("fecha_Desde");
            $table->dateTime("fecha_Hasta");
            $table->enum('precio', ['0', '500', '1000' ]);    

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
