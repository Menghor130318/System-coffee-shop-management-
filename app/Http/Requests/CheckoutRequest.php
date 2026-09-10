<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'customer_phone' => 'required|string|max:20',

            'shipping_address' => 'required|string|max:500',

            'note' => 'nullable|string|max:255',
            // ======================
            // GIỎ HÀNG
            // ======================

            'items' => 'required|array|min:1',

            'items.*.product.id' => 'required|exists:products,id',

            'items.*.size.id' => 'nullable|exists:sizes,id',

            'items.*.sweetness.id' => 'nullable|exists:sweetness_levels,id',

            'items.*.ice.id' => 'nullable|exists:ice_levels,id',

            'items.*.toppings' => 'array',

            'items.*.toppings.*.id' => 'exists:toppings,id',

            'items.*.quantity' => 'required|integer|min:1',

            'items.*.unitPrice' => 'required|numeric',

            'items.*.total' => 'required|numeric',
        ];
    }
}
