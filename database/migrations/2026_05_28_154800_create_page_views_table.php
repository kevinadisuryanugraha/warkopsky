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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('page_name', 100)->nullable();
            $table->string('ip_address', 45); // Supports IPv6
            $table->text('user_agent')->nullable();
            $table->string('browser', 80)->nullable();
            $table->string('platform', 80)->nullable();
            $table->string('device_type', 20)->nullable(); // desktop, mobile, tablet
            $table->string('referer', 500)->nullable();
            $table->string('country', 80)->nullable(); // Future-proof for GeoIP
            $table->string('session_id', 120)->nullable();
            $table->timestamp('visited_at')->useCurrent();

            // Performance indexes for analytics queries
            $table->index('visited_at');
            $table->index('page_name');
            $table->index('ip_address');
            $table->index('session_id');
            $table->index('device_type');
            $table->index('browser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
