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
        Schema::table('requests', function (Blueprint $table) {
            // Modificar columna book_id para permitir valores nulos
            $table->unsignedBigInteger('book_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            // Revertir y hacer la columna obligatoria nuevamente
            $table->unsignedBigInteger('book_id')->nullable(false)->change();
        });
    }
};
