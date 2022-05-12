<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentacionAuthUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentacion_auth_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('idAuthUsuario');
            $table->string('nombreDocOriginal')->nullable();
            $table->string('nombreDocAutogenerado')->nullable();
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
        Schema::dropIfExists('documentacion_auth_usuarios');
    }
}
