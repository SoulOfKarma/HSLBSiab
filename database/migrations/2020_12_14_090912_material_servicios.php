<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaterialServicios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_servicios', function (Blueprint $table) {

            $table->id();
            $table->string('descripcion_servicio');
            $table->bigInteger('id_material_ubicacion')->unsigned();
            $table->foreign('id_material_ubicacion')->references('id')->on('material_ubicaciones');
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
        Schema::dropIfExists('material_servicios');
    }
}
