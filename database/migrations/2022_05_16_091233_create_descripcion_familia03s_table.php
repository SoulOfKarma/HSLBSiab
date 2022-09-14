<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescripcionFamilia03sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcion_familia03', function (Blueprint $table) {
            $table->id();
            $table->string('descripcionFamilia');
            $table->BigInteger('CODFAM4')->nullable();
            $table->BigInteger('idDesFam02');
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
        Schema::dropIfExists('descripcion_familia03');
    }
}
