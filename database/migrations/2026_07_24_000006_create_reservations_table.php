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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code')->nullable()->unique();
            $table->string('customer_name');
            $table->string('customer_phone', 20)->nullable();
            $table->date('reservation_date')->nullable();
            $table->time('reservation_time')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->string('table_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
