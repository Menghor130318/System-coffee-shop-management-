<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'category_id' => 'required|exists:categories,id',

            'name' => [
                'required',
                Rule::unique('products', 'name')->ignore($product->id),
            ],

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'use_all_toppings' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [

            'category_id.required' => 'Vui lòng chọn danh mục.',

            'category_id.exists' => 'Danh mục không hợp lệ.',

            'name.required' => 'Vui lòng nhập tên món.',

            'name.unique' => 'Tên món đã tồn tại.',

            'price.required' => 'Vui lòng nhập giá.',

        ];
    }
}
