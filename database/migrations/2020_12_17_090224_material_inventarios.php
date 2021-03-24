<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaterialInventarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_inventarios', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('id_ubicaciones');
            $table->bigInteger('id_servicios');
            $table->bigInteger('id_cubiculo')->nullable();
            $table->bigInteger('id_material_ing');
            $table->bigInteger('id_cant_esp');
            $table->bigInteger('id_material_medida');
            $table->bigInteger('material_cantidad');
            $table->bigInteger('material_valor')->nullable();
            $table->double('material_cantidad_calculada',15,2);
            $table->bigInteger('id_documento');
            $table->string('n_documento');
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
        Schema::dropIfExists('material_inventarios');
    }
}
