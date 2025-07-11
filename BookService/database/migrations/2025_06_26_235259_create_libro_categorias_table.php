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
        Schema::create('libro_categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libro_id');
            $table->integer('id_categoria');

            $table->foreign('libro_id')->references('id')->on('book')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_categorias');
    }
};
