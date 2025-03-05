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
            $table->enum('tipo', ['entrada', 'salida']); // Tipo de movimiento
            $table->unsignedBigInteger('proveedor')->nullable(); // Proveedor (opcional)
            $table->unsignedBigInteger('responsable'); // Responsable (usuario logueado)
            $table->date('fecha'); // Fecha del movimiento
            $table->text('observacion')->nullable(); // Observación (opcional)
            $table->timestamps();
    
            // Claves foráneas
            $table->foreign('proveedor')->references('id')->on('providers')->onDelete('set null');
            $table->foreign('responsable')->references('id')->on('users')->onDelete('cascade');
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
