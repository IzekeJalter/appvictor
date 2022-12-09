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
        Schema::create('parque_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parque_id');
            $table->foreign('parque_id')->references('id')->on('parques');
            $table->string('nombre_area', 30);
            $table->string('descripcion', 250);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('parque_areas');
    }
};
