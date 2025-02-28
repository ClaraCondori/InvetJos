<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // 1. Eliminar la clave foránea primero
            $table->dropForeign(['rol_id']);

            // 2. Luego eliminar la columna
            $table->dropColumn('rol_id');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            // 3. Restaurar la columna si se hace rollback
            $table->unsignedBigInteger('rol_id')->nullable();

            // 4. Restaurar la clave foránea
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }
};
