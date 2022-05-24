<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespachoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despacho_detalles', function (Blueprint $table) {
            $table->id();
            $table->string('FOLIO')->nullable();
            $table->date('FECSYS')->nullable();
            $table->date('FECDES')->nullable();
            $table->bigInteger('idServicio')->nullable();
            $table->string('NOMTIPCON')->nullable();
            $table->string('TIPPRE')->nullable();
            $table->string('NUMPRO')->nullable();
            $table->string('NUMLIBRO')->nullable();
            $table->string('CODDIG')->nullable();
            $table->string('NOMDIG')->nullable();
            $table->string('LOTE')->nullable();
            $table->date('FECVEN')->nullable();
            $table->string('CODBAR')->nullable();
            $table->string('CODART')->nullable();
            $table->string('NOMART')->nullable();
            $table->string('UNIMED')->nullable();
            $table->decimal('CANTIDAD',12,2)->nullable();
            $table->decimal('PRECIO',11,2)->nullable();
            $table->string('CODART_TRACK')->nullable();
            $table->string('CODART_ONU')->nullable();
            $table->string('TIPBOD')->nullable();
            $table->bigInteger('LINEA')->nullable();
            $table->boolean('ACT_FECVEN')->nullable();
            $table->decimal('CANTXENB',7,2)->nullable();
            $table->string('USUING')->nullable();
            $table->string('USUMOD')->nullable();
            $table->string('NUMINT')->nullable();
            $table->string('CODMOT')->nullable();
            $table->string('NOMMOT')->nullable();
            $table->string('FOLIO_FCIA')->nullable();
            $table->string('FOLIO_SOL')->nullable();
            $table->string('CODINT2')->nullable();
            $table->string('ART_ESP')->nullable();
            $table->string('TIPDESP')->nullable();
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
        Schema::dropIfExists('despacho_detalles');
    }
}
