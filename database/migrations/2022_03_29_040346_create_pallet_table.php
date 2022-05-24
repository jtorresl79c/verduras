<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pallet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_remision');
            $table->foreign('id_remision')->references('id')->on('remision');

            $table->decimal('peso_bruto',12,2);
            $table->integer('cajas')->default(0);
            $table->decimal('tara',12,2)->default(0);
            $table->decimal('kg_prom',12,2)->default(0);
            $table->decimal('peso_neto',12,2)->default(0);

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
        Schema::dropIfExists('pallet');
    }
}
