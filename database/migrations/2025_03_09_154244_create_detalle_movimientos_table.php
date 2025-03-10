<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleMovimientosTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_movimientos', function (Blueprint $table) {
            $table->id(); // Equivalente a $table->bigIncrements('id')
            $table->unsignedBigInteger('movimiento_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->decimal('precio_comp', 8, 2)->nullable(); // Agrega esta línea si es necesario
            $table->timestamps(); // created_at y updated_at

            // Claves foráneas
            $table->foreign('movimiento_id')->references('id')->on('movimientos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_movimientos');
    }
}