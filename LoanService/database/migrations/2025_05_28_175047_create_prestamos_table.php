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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libro_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sancion_id')->nullable();
            $table->timestamp('fecha_prestamo');
            $table->timestamp('fecha_devolucion_prevista');
            $table->timestamp('fecha_devolucion_real')->nullable();
            $table->string('estado', 50);
            $table->timestamps();
            $table->softDeletes();

            $table->index('libro_id');
            $table->index('user_id');
            $table->index('sancion_id');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
