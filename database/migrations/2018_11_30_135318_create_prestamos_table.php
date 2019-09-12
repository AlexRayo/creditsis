<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idCliente')->unsigned();
            $table->foreign('idCliente')->references('id')->on('clientes')->onDelete('cascade');
            $table->decimal('monto');
            $table->decimal('interes');
            $table->bigInteger('cantidadCuotas')->nullable();
            $table->decimal('valorCuota');
            $table->decimal('totalCancelar')->nullable();;
            $table->decimal('saldo')->nullable();;
            $table->decimal('utilidad')->nullable();
            $table->dateTime('fechaProxCuota');
            $table->decimal('observaciones')->nullable();
            $table->text('estado')->nullable();
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
        Schema::dropIfExists('prestamos');
    }
}
