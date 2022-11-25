<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id();
            $table->string('FOLIO')->unique()->nullable();
            $table->string('RUTPRO')->nullable();
            $table->string('NOMPRO')->nullable();
            $table->date('FECORD')->nullable();
            $table->string('NUMINT')->unique()->nullable();
            $table->string('NUMSIGFE')->nullable();
            $table->date('FECSYS')->nullable();
            $table->string('OBS')->nullable();
            $table->string('ANIO')->nullable();
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
        Schema::dropIfExists('orden_compras');
    }
}
