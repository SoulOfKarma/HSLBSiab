<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcionFamiliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcion_familia', function (Blueprint $table) {
            $table->id();
            $table->string('descripcionFamilia');
            $table->BigInteger('CODFAM1')->nullable();
            $table->BigInteger('idBodega')->unsigned();
            $table->foreign('idBodega')->references('id')->on('bodega');
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
        Schema::dropIfExists('descripcion_familia');
    }
}
