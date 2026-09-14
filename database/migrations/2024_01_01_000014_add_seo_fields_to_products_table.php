<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('ai_description')->nullable()->after('meta_description');
            $table->string('keywords', 500)->nullable()->after('ai_description');
            $table->string('og_image')->nullable()->after('keywords');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['ai_description', 'keywords', 'og_image']);
        });
    }
};
