<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcionFamilia05sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcion_familia05', function (Blueprint $table) {
            $table->id();
            $table->string('descripcionFamilia');
            $table->BigInteger('CODFAM6');
            $table->BigInteger('idDesFam04');
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
        Schema::dropIfExists('descripcion_familia05');
    }
}
