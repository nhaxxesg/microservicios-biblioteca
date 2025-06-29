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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin');
            $table->integer('id_lector');
            $table->integer('id_libro');
            $table->date('loan_date');
            $table->date('f_devolucion_establecida');
            $table->date('f_devolucion_real')->nullable();
            $table->enum('estado', ['pendiente', 'devuelto', 'activo'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
