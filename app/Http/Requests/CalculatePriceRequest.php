<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'size_id' => 'required|exists:sizes,id',

            'sweetness_level_id' => 'nullable|exists:sweetness_levels,id',

            'ice_level_id' => 'nullable|exists:ice_levels,id',

            'topping_ids' => 'nullable|array',

            'topping_ids.*' => 'exists:toppings,id',

            'quantity' => 'required|integer|min:1'

        ];
    }
}