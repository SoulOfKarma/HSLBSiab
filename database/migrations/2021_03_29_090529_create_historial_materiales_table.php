<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_materiales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_material_inventario');
            $table->bigInteger('id_ubicaciones');
            $table->bigInteger('id_servicios')->nullable();
            $table->bigInteger('id_cubiculo')->nullable();
            $table->bigInteger('id_material_ing');
            $table->bigInteger('id_cant_esp')->nullable();
            $table->bigInteger('id_material_medida');
            $table->bigInteger('material_cantidad');
            $table->bigInteger('material_cantidad_minima');
            $table->bigInteger('material_valor')->nullable();
            $table->double('material_cantidad_calculada',15,2);
            $table->bigInteger('id_documento');
            $table->string('n_documento');
            $table->string('id_ticket');
            $table->bigInteger('id_categoria')->nullable();
            $table->string('id_estados');
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
        Schema::dropIfExists('historial_materiales');
    }
}
