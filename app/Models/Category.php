<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name_kh',
        'category_name_en',
        'category_name_zh',
        'name',
        'name_en',
        'name_zh',
        'slug',
        'description',
        'image',
        'status',
        'sort_order',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }


    public static function firstOrCreateByName(string $name, array $attributes = []): self
    {
        $normalizedName = trim($name);
        $slug = $attributes['slug'] ?? Str::slug($normalizedName);

        $existingCategory = static::where(function ($query) use ($normalizedName, $slug): void {
            $query->where('category_name_kh', $normalizedName)
                ->orWhere('category_name_en', $normalizedName)
                ->orWhere('category_name_zh', $normalizedName)
                ->orWhere('name', $normalizedName)
                ->orWhere('name_en', $normalizedName)
                ->orWhere('name_zh', $normalizedName);

            if (!empty($slug)) {
                $query->orWhere('slug', $slug);
            }
        })->first();

        if ($existingCategory) {
            return $existingCategory;
        }

        return static::create(array_merge([
            'category_name_kh' => $normalizedName,
            'name' => $normalizedName,
            'slug' => $slug,
            'status' => true,
            'sort_order' => $attributes['sort_order'] ?? null,
        ], $attributes));
    }
}