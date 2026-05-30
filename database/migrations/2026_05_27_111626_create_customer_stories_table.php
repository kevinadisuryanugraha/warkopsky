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
        Schema::create('customer_stories', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('instagram_handle')->nullable();
            $table->string('quote');
            $table->text('text');
            $table->integer('rating')->default(5);
            $table->string('media_path')->nullable();
            $table->enum('media_type', ['image', 'video', 'none'])->default('none');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_stories');
    }
};
