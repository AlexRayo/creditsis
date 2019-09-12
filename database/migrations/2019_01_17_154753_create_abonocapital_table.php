<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonocapitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonocapital', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idPrestamo')->unsigned();
            $table->foreign('idPrestamo')->references('id')->on('prestamos')->onDelete('cascade');            
            $table->decimal('cuota');
            $table->decimal('observaciones')->nullable();
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
        Schema::dropIfExists('abonocapital');
    }
}
