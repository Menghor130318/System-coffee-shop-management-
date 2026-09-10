<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',

            'name' => 'required|string|max:255|unique:products,name',

            'slug' => 'nullable',

            'price' => 'required|numeric|min:0',

            'sale_price' => 'nullable|numeric|min:0',

            'description' => 'nullable|string',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20480',

            'status' => 'boolean',
            
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
