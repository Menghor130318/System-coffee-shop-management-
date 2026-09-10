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
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // ការពារ Error 30 (Foreign key constraint)
            
            $table->id();

            // កំណត់ Foreign Key ឱ្យកាន់តែច្បាស់លាស់ និងអនុញ្ញាតឱ្យ Nullable
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained('categories')
                  ->nullOnDelete();

            // បន្ថែម Column ឈ្មោះផលិតផលតាមភាសា
            $table->string('product_name_kh')->nullable();
            $table->string('product_name_en')->nullable();
            $table->string('product_name_zh')->nullable();
            $table->string('name')->nullable(); // រក្សាទុកបង្ការ Controller ចាស់

            $table->string('slug')->nullable();
            $table->string('image')->nullable();

            // បន្ថែម Column តម្លៃថ្មី និងរក្សាទុកតម្លៃចាស់
            $table->decimal('price_min', 10, 2)->default(0.00);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('sale_price', 10, 2)->nullable();

            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('use_all_toppings')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};