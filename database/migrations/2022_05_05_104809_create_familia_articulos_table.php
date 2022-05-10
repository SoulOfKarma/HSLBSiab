<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia_articulo', function (Blueprint $table) {
            $table->id();
            $table->string('CODFAM1')->nullable();
            $table->string('NOMFAM1')->nullable();
            $table->string('CODFAM2')->nullable();
            $table->string('NOMFAM2')->nullable();
            $table->string('CODFAM3')->nullable();
            $table->string('NOMFAM3')->nullable();
            $table->string('CODFAM4')->nullable();
            $table->string('NOMFAM4')->nullable();
            $table->string('CODFAM5')->nullable();
            $table->string('NOMFAM5')->nullable();
            $table->string('CODFAM6')->nullable();
            $table->string('NOMFAM6')->nullable();
            $table->string('CODFAM7')->nullable();
            $table->string('NOMFAM7')->nullable();
            $table->string('BODEGA')->nullable();
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
        Schema::dropIfExists('familia_articulo');
    }
}
