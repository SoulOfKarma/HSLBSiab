<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_detalles', function (Blueprint $table) {
            $table->id();
            $table->string('FOLIO')->nullable();
            $table->string('RUTPRO')->nullable();
            $table->string('NOMPRO')->nullable();
            $table->date('FECORD')->nullable();
            $table->string('NUMINT')->nullable();
            $table->string('NUMSIGFE')->nullable();
            $table->string('TIPDOC')->nullable();
            $table->string('NUMDOC')->nullable();
            $table->date('FECDOC')->nullable();
            $table->decimal('TOTAL',12,2)->nullable();
            $table->date('FECSYS')->nullable();
            $table->string('FOLREC')->unique()->nullable();
            $table->string('NOMORD')->nullable();
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
        Schema::dropIfExists('orden_compra_detalles');
    }
}
