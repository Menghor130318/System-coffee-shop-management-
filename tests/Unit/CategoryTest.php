<?php

namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        app('db')->purge('sqlite');

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('name_zh')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function test_first_or_create_by_name_reuses_existing_category(): void
    {
        $existing = Category::create([
            'name' => 'Cafe',
            'slug' => 'cafe',
            'status' => true,
        ]);

        $category = Category::firstOrCreateByName('Cafe', [
            'slug' => 'cafe-duplicate',
            'status' => true,
        ]);

        $this->assertSame($existing->id, $category->id);
        $this->assertSame(1, Category::count());
    }
}
