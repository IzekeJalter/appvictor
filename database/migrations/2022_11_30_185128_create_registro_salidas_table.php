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
        Schema::create('registro_salidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarjeta_id');
            $table->foreign('tarjeta_id')->references('id')->on('tarjetas');
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
        Schema::dropIfExists('registro_salidas');
    }
};
