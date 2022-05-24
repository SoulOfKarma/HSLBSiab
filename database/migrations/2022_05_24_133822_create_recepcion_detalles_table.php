<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcion_detalles', function (Blueprint $table) {
            $table->id();
            $table->string('FOLIO')->nullable();
            $table->date('FECSYS')->nullable();
            $table->date('FECDES')->nullable();
            $table->bigInteger('LINEA')->nullable();
            $table->string('CODBAR')->nullable();
            $table->decimal('IVA',14,3)->nullable();
            $table->string('CODART_OC')->nullable();
            $table->string('PRODUCTO')->nullable();
            $table->string('CANTIDAD')->nullable();
            $table->string('ESPCOM',400)->nullable();
            $table->string('ESPPRO',400)->nullable();
            $table->decimal('PREUNI',11)->nullable();
            $table->decimal('VALTOT',12,2)->nullable();
            $table->decimal('DCTO',10,2)->nullable();
            $table->decimal('CARGO',10,2)->nullable();
            $table->decimal('IMPADICIONAL',5)->nullable();
            $table->decimal('CANREC',14,2)->nullable();
            $table->decimal('CANRECH',14,2)->nullable();
            $table->decimal('TOTREC',12,2)->nullable();
            $table->string('FL')->nullable();
            $table->string('MARCA')->nullable();
            $table->decimal('PREUNI2',13,2)->nullable();
            $table->string('UNIMED')->nullable();
            $table->decimal('PENDIENTE',12)->nullable();
            $table->string('CODART')->nullable();
            $table->string('LOTE')->nullable();
            $table->date('FECVEN')->nullable();
            $table->boolean('ACT_FECVEN')->nullable();
            $table->decimal('AJUSTE',3)->nullable();
            $table->string('USUING')->nullable();
            $table->string('USUMOD')->nullable();
            $table->string('NUMINT')->nullable();
            $table->string('CODMOT')->nullable();
            $table->string('NOMMOT')->nullable();
            $table->string('CODINT2')->nullable();
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
        Schema::dropIfExists('recepcion_detalles');
    }
}
