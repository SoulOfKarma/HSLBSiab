<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcionFamilia06sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcion_familia06', function (Blueprint $table) {
            $table->id();
            $table->string('descripcionFamilia');
            $table->BigInteger('CODFAM7');
            $table->BigInteger('idDesFam05');
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
        Schema::dropIfExists('descripcion_familia06');
    }
}
