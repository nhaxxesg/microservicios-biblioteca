<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_notificaciones', function (Blueprint $table) {
            $table->id();
            $table->uuid('tracking_id')->unique()->index();
            $table->string('event_source_id')->index();
            $table->string('event_type', 100)->index();
            $table->string('recipient_email');
            $table->string('subject');
            $table->string('template_used', 100)->nullable();
            $table->string('status', 50)->index();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->unsignedSmallInteger('attempts')->default(0);
            $table->text('error_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_notificaciones');
    }
};
