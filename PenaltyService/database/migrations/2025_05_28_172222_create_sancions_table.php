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
        Schema::create('sancions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->text('motivo');
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');
            $table->string('estado', 50);
            $table->timestamps();
            $table->softDeletes();

            $table->index('usuario_id');
            $table->index('estado');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sancions');
    }
};
