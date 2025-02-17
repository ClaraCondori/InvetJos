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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id'); // Asegúrate de que el tipo coincida con la columna referenciada
        
            // Definir la llave foránea
            $table->foreign('categoria_id') // Columna en esta tabla
                  ->references('id')            // Columna en la tabla referenciada
                  ->on('categorias')       // Nombre de la tabla referenciada
                  ->onDelete('cascade');         // Opcional: define el comportamiento al eliminar (cascade, set null, etc.)
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('precio_vent');
            $table->string('precio_comp');
            $table->string('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
