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
            $table->mediumInteger('r_codigo')->nullable();
            $table->mediumInteger('ca_1')->nullable();
            $table->mediumInteger('ca_2')->nullable();
            $table->Integer('chat_id')->nullable();
            $table->string('path_foto',200)->nullable();
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
