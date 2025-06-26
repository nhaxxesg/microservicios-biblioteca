<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->integer('id_autor');
            $table->string('titulo');
            $table->integer('anio_publicacion');
            $table->integer('ejemplares')->default(1);
            $table->enum('estado', ['disponible', 'prestado'])->default('disponible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book');
    }
};
