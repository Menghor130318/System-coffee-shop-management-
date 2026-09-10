<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'name' => $this->name,

            'slug' => $this->slug,

            'image' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'price' => (float)$this->price,

            'sale_price' => $this->sale_price
                ? (float)$this->sale_price
                : null,

            'description' => $this->description,

            'status' => (bool)$this->status,

            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ],

            'sizes' => $this->sizes->map(function ($size) {
                return [
                    'id' => $size->id,
                    'name' => $size->name,
                    'price' => (float) $size->pivot->price,
                ];
            }),

            'sweetness_levels' => $this->sweetnessLevels->map(function ($level) {
                return [
                    'id' => $level->id,
                    'name' => $level->name,
                ];
            }),

            'ice_levels' => $this->iceLevels->map(function ($level) {
                return [
                    'id' => $level->id,
                    'name' => $level->name,
                ];
            }),

            'toppings' => $this->toppings->map(function ($topping) {
                return [
                    'id' => $topping->id,
                    'name' => $topping->name,
                    'price' => (float) $topping->price,
                ];
            }),

            'reviews' => $this->reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at,
                ];
            }),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
