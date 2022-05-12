<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorizadoretirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizadoretiro', function (Blueprint $table) {
            $table->id();
            $table->string('RUN')->nullable();
            $table->string('NOMBRES')->nullable();
            $table->string('APELLIDOS')->nullable();
            $table->date('FECINI')->nullable();
            $table->date('FECFIN')->nullable();
            $table->bigInteger('idEstado')->nullable();
            $table->bigInteger('idServicio')->nullable();
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
        Schema::dropIfExists('autorizadoretiro');
    }
}
