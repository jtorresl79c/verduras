<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remision', function (Blueprint $table) {
            $table->id();
            $table->string('lote');
            $table->string('remision');
            $table->string('chofer');
            $table->string('contenedor');
            $table->string('producto');
            $table->decimal('kgs',12,2);
            $table->integer('cajas')->default(0);
            $table->string('recibio');
            $table->dateTime('fecha_envio');
            $table->dateTime('fecha_recibido');
            $table->dateTime('fecha_descarga');
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
        Schema::dropIfExists('remision');
    }
}
