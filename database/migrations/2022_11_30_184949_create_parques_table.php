<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parques', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 25);
            $table->unsignedBigInteger('dueño_id');
            $table->foreign('dueño_id')->references('id')->on('users');
            $table->string('reglas', 1000);
            $table->integer('medida_largoTerreno');
            $table->integer('medida_anchoTerreno');
            $table->unsignedBigInteger('cantidad_sensores');
            $table->unsignedBigInteger('cantidad_entradas');
            $table->unsignedBigInteger('cantidad_salidas');
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
        Schema::dropIfExists('parques');
    }
};
