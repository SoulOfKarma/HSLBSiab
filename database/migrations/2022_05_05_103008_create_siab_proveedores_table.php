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
        Schema::create('siab_proveedor', function (Blueprint $table) {
            $table->id();
            $table->string('LLAVEPROVEEDOR')->nullable();
            $table->string('CODFORMAPAGO')->nullable();
            $table->string('CODCOM')->nullable();
            $table->string('CODCIU')->nullable();
            $table->string('CODRUB')->nullable();
            $table->string('CODSIT')->nullable();
            $table->string('CODEST')->nullable();
            $table->string('NUMCRE')->nullable();
            $table->string('RUTPROV')->nullable();
            $table->string('NOMRAZSOC')->nullable();
            $table->string('NOMFAN')->nullable();
            $table->string('CTACTEPROV')->nullable();
            $table->string('DIRPROV')->nullable();
            $table->string('TELPROV')->nullable();
            $table->string('CELPROV')->nullable();
            $table->string('FAXPROV')->nullable();
            $table->string('EMAILPROV')->nullable();
            $table->string('NOMVENPROV')->nullable();
            $table->string('CODBAN')->nullable();
            $table->string('NOMPERPOD')->nullable();
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
        Schema::dropIfExists('siab_proveedor');
    }
}
