<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_movimiento');
            $table->foreign('id_movimiento') // Columna en esta tabla
                  ->references('id')            // Columna en la tabla referenciada
                  ->on('movimientos')       // Nombre de la tabla referenciada
                  ->onDelete('cascade');         // Opcional: define el comportamiento al eliminar (cascade, set null, etc.)
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id') // Columna en esta tabla
                    ->references('id')            // Columna en la tabla referenciada
                    ->on('productos')       // Nombre de la tabla referenciada
                    ->onDelete('cascade');         // Opcional: define el comportamiento al eliminar (cascade, set null, etc.)
            $table->integer('cantidad'); // Cantidad de productos
            $table->decimal('precio_unitario', 10, 2); // Precio unitario del producto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_movimientos');
    }
};
