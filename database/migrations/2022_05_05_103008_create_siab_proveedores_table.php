<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiabProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siab_proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('LLAVEPROVEEDOR');
            $table->string('CODFORMAPAGO');
            $table->string('CODCOM');
            $table->string('CODCIU');
            $table->string('CODRUB');
            $table->string('CODSIT');
            $table->string('CODEST');
            $table->string('NUMCRE');
            $table->string('RUTPROV');
            $table->string('NOMRAZSOC');
            $table->string('NOMFAN');
            $table->string('CTACTEPROV');
            $table->string('DIRPROV');
            $table->string('TELPROV');
            $table->string('CELPROV');
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
        Schema::dropIfExists('siab_proveedores');
    }
}
