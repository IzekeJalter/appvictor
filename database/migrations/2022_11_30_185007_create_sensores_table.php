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
        Schema::create('sensores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parque_id');
            $table->foreign('parque_id')->references('id')->on('parques');
            $table->string('nombre_sensor', 40);
            $table->unsignedBigInteger('area_parque');
            $table->foreign('area_parque')->references('id')->on('parque_areas');
            $table->string('informacion', 300);
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
        Schema::dropIfExists('sensores');
    }
};
