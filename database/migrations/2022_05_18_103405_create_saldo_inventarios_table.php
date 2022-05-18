<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_inventario', function (Blueprint $table) {
            $table->id();
            $table->string('CODART_TRACK')->nullable();
            $table->string('NOMBRE')->nullable();
            $table->string('GENERICO')->nullable();
            $table->string('CAT_FARMACIA')->nullable();
            $table->string('UNIMEDBASE')->nullable();
            $table->string('CONCENTRACION')->nullable();
            $table->string('CODART_ONU')->nullable();
            $table->string('CODART')->nullable();
            $table->string('CODART_BARR')->nullable();
            $table->bigInteger('idEstado')->nullable();
            $table->boolean('ACT_FECVEN')->nullable();
            $table->string('LABORATORIO')->nullable();
            $table->decimal('CANTXENB',7,2)->nullable();
            $table->boolean('ACT_LOTE')->nullable();
            $table->boolean('ACT_SERIE')->nullable();
            $table->bigInteger('idBodega')->nullable();
            $table->bigInteger('idFam1')->nullable();
            $table->bigInteger('idFam2')->nullable();
            $table->bigInteger('idFam3')->nullable();
            $table->bigInteger('idFam4')->nullable();
            $table->bigInteger('idFam5')->nullable();
            $table->date('FECVEN')->nullable();
            $table->string('LOTE')->nullable();
            $table->decimal('CANTIDAD',14,3)->nullable();
            $table->date('FECINV')->nullable();
            $table->string('LINEA')->nullable();
            $table->decimal('PRECIO',13,2)->nullable();
            $table->bigInteger('idZona')->nullable();
            $table->string('SECTOR')->nullable();  
            $table->string('UBICACION')->nullable();          
            $table->string('CODINT2')->nullable();
            $table->bigInteger('SALDO')->nullable();
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
        Schema::dropIfExists('saldo_inventario');
    }
}
