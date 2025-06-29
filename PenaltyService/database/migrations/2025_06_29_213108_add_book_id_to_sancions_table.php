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
        Schema::table('sancions', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id')->after('usuario_id');
            $table->index('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sancions', function (Blueprint $table) {
            $table->dropIndex(['book_id']);
            $table->dropColumn('book_id');
        });
    }
};
