<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepciones', function (Blueprint $table) {
            $table->id();
            $table->string('FOLIO')->unique()->nullable();
            $table->date('FECSYS')->nullable();
            $table->date('FECDES')->nullable();
            $table->string('RUTPRO')->nullable();
            $table->string('NOMPRO')->nullable();
            $table->string('TIPBOB')->nullable();
            $table->string('NUMDOC')->nullable();
            $table->string('NUMFAC')->nullable();
            $table->string('FECFAC')->nullable();
            $table->string('CODDIG')->nullable();
            $table->string('NOMDIG')->nullable();
            $table->string('NUMORD')->nullable();
            $table->string('TIPDOC')->nullable();
            $table->string('FECDOC')->nullable();
            $table->string('DCTO')->nullable();
            $table->string('OBS')->nullable();
            $table->string('CARGO')->nullable();
            $table->decimal('SUBTOTAL',16,2)->nullable();
            $table->string('AJUSTE')->nullable();
            $table->string('USUING')->nullable();
            $table->string('USUMOD')->nullable();
            $table->string('NUMINT')->unique()->nullable();
            $table->string('NUMREC_RF')->nullable();
            $table->string('NOTCRE_RF')->nullable();
            $table->string('NUMRIB')->nullable();
            $table->string('NOMARCH')->nullable();
            $table->string('NOMARCH_RIB')->nullable();
            $table->string('NOMARCH_CAR')->nullable();
            $table->bigInteger('idServicio')->nullable();
            $table->string('NUMLIBPED')->nullable();
            $table->string('TIPRECEPCION');
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
        Schema::dropIfExists('recepciones');
    }
}
