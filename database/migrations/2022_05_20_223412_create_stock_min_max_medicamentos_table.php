<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMinMaxMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_min_max_medicamento', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idBodega')->nullable();
            $table->bigInteger('idEstadoStock')->nullable();
            $table->string('CODART')->nullable();
            $table->string('NOMBRE')->nullable();
            $table->string('UNIMEDBASE')->nullable();
            $table->bigInteger('STOCK_MIN')->nullable();
            $table->bigInteger('STOCK_MAX')->nullable();
            $table->bigInteger('STOCK_CRI')->nullable();
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
        Schema::dropIfExists('stock_min_max_medicamento');
    }
}
