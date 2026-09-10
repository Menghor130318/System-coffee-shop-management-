<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add multilingual name columns (English & Chinese) to products.
     *
     * - name      = Khmer (ខ្មែរ)
     * - name_en   = English (English)
     * - name_zh   = Chinese (中文)
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('name_zh')->nullable()->after('name_en');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_zh']);
        });
    }
};
