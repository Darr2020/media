<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioPerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('usuario_perfil', function (Blueprint $table) {
            $table->integer('usuario_id');
	    $table->integer('perfil_id');

	    $table->foreign('usuario_id')->references('id')->on('usuario')
                ->onUpdate('cascade')->onDelete('cascade');
	    $table->foreign('perfil_id')->references('id')->on('perfil')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['usuario_id', 'perfil_id']);

            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_perfil');
    }
}
