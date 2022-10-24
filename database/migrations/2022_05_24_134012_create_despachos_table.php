<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespachosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despachos', function (Blueprint $table) {
            $table->id();
            $table->string('FOLIO')->unique()->nullable();
            $table->date('FECSYS')->nullable();
            $table->date('FECDES')->nullable();
            $table->bigInteger('idServicio')->nullable();            
            $table->string('NOMSER')->nullable();
            $table->string('NOMTIPCON')->nullable();
            $table->string('TIPPRE')->nullable();
            $table->string('NUMPRO')->nullable();
            $table->string('NUMLIBRO')->nullable();
            $table->string('CODDIG')->nullable();
            $table->string('NOMDIG')->nullable();
            $table->string('TIPBOD')->nullable();
            $table->string('OBS')->nullable();
            $table->string('CODART_ONU')->nullable();
            $table->string('USUING')->nullable();
            $table->string('USUMOD')->nullable();
            $table->string('NUMINT')->unique()->nullable();
            $table->string('FOLIO_FCIA')->nullable();
            $table->string('FOLIO_SOL')->nullable();
            $table->string('TIPDESP')->nullable();
            $table->string('NUMPESP')->nullable();
            $table->string('NUMSOL')->nullable();
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
        Schema::dropIfExists('despachos');
    }
}
