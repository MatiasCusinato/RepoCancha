<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canchas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("club_configuracion_id");
            $table->foreign('club_configuracion_id')
                    ->references('id')->on('club_configuracions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                    
            $table->string("deporte", 30);

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
        Schema::dropIfExists('canchas');
    }
}
