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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->date('tipo');
            $table->date('fecha');
            $table->unsignedBigInteger('responsable');
            $table->foreign('responsable') // Columna en esta tabla
                  ->references('id')            // Columna en la tabla referenciada
                  ->on('users')       // Nombre de la tabla referenciada
                  ->onDelete('cascade');         // Opcional: define el comportamiento al eliminar (cascade, set null, etc.)
            $table->string('observacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
