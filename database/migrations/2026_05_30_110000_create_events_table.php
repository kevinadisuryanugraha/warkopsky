<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', [
                'nobar',
                'live_music',
                'special_event',
                'promo',
                'tournament',
                'lainnya',
            ])->default('lainnya');
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->time('event_time_start');
            $table->time('event_time_end')->nullable();
            $table->string('location')->default('Warkop Sky');
            $table->string('poster_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
