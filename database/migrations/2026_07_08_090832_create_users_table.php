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
    Schema::create('users', function (Blueprint $table) {

        $table->id();

        $table->foreignId('role_id')
              ->constrained('roles')
              ->cascadeOnUpdate()
              ->restrictOnDelete();

        $table->string('full_name',100);

        $table->string('email')->unique();

        $table->string('password');

        $table->string('phone',20)->nullable();

        $table->text('address')->nullable();

        $table->string('avatar')->nullable();

        $table->boolean('status')->default(true);

        $table->rememberToken();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
