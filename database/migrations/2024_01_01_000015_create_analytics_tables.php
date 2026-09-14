<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 500);
            $table->string('full_url', 1000)->nullable();
            $table->string('method', 10)->default('GET');
            $table->string('referrer', 1000)->nullable();
            $table->string('referrer_host', 255)->nullable();
            $table->string('utm_source', 120)->nullable();
            $table->string('utm_medium', 120)->nullable();
            $table->string('utm_campaign', 160)->nullable();
            $table->string('ip_hash', 64)->nullable()->index();
            $table->string('session_id', 120)->nullable()->index();
            $table->string('user_agent', 500)->nullable();
            $table->string('device', 40)->nullable()->index();
            $table->string('browser', 60)->nullable();
            $table->string('country', 80)->nullable();
            $table->boolean('is_bot')->default(false)->index();
            $table->unsignedInteger('response_time_ms')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index(['path', 'created_at']);
        });

        Schema::create('admin_activities', function (Blueprint $table) {
            $table->id();
            $table->string('type', 60);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_activities');
        Schema::dropIfExists('page_views');
    }
};
