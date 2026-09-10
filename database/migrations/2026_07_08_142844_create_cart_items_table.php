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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cart_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('size_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('sweetness_level_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('ice_level_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->json('topping_ids')->nullable();

            $table->integer('quantity');

            $table->decimal('unit_price', 10, 2);

            $table->decimal('total_price', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
