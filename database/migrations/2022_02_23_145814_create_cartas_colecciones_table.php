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
        Schema::create('cartas_colecciones', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('carta_id');
            $table->unsignedBigInteger('coleccion_id');
            $table->foreign('carta_id')->references('id')->on('cartas')->onDelete('cascade');;
            $table->foreign('coleccion_id')->references('id')->on('colecciones')->onDelete('cascade');;
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
        Schema::dropIfExists('cartas_colecciones');
    }
};
