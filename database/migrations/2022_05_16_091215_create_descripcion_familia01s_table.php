<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcionFamilia01sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcion_familia01', function (Blueprint $table) {
            $table->id();
            $table->string('descripcionFamilia');            
            $table->BigInteger('CODFAM2')->nullable();
            $table->BigInteger('idDesFam');
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
        Schema::dropIfExists('descripcion_familia01');
    }
}
