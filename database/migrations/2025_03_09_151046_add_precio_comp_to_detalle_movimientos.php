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
        Schema::table('detalle_movimientos', function (Blueprint $table) {
            //
            $table->decimal('precio_comp', 8, 2)->after('cantidad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_movimientos', function (Blueprint $table) {
            //
            $table->dropColumn('precio_comp');
        });
    }
};
