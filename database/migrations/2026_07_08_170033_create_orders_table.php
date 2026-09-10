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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('customer_name');

            $table->string('phone');

            $table->string('email')->nullable();

            $table->text('address');

            $table->text('note')->nullable();

            $table->decimal('subtotal', 10, 2);

            $table->decimal('shipping_fee', 10, 2)->default(0);

            $table->decimal('discount', 10, 2)->default(0);

            $table->decimal('total', 10, 2);

            $table->string('payment_method');

            $table->string('payment_status')->default('pending');

            $table->string('status')->default('waiting_payment');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
