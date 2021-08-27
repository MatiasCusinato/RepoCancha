<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //$table->string('name');
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('email')->unique();            
            $table->integer("telefono");
            $table->string('password');
            
            $table->unsignedBigInteger("club_configuracion_id")->nullable();
            $table->foreign('club_configuracion_id')
                    ->references('id')->on('club_configuracions')
                    ->onDelete('set null');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
