<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cuenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cuenta', function (Blueprint $table) {
            $table->id();
            $table->string('correo',100);
            $table->string('contra',300);
            $table->string('ca_1',10)->nullable();
            $table->string('time_stamp1',20)->nullable();
            $table->string('ca_2',10)->nullable();
             $table->string('time_stamp2',20)->nullable();
            $table->string('chat_id',100)->nullable();
            $table->unsignedBigInteger('id_estatus');
            $table->foreign('id_estatus')->references('id')->on('estatus');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('usuario');
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
        //
    }
}
