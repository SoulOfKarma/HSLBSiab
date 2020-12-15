<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaterialTipos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_tipos', function (Blueprint $table) {

            $table->id();
            $table->string('descripcion_tipo_material');
            $table->bigInteger('id_material')->unsigned();
            $table->foreign('id_material')->references('id')->on('material_ingresados');
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
        Schema::dropIfExists('material_tipos');
    }
}
