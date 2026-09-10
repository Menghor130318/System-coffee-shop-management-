<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],

            'slug' => [
                'nullable',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($categoryId),
            ],

            'image' => 'nullable|string',

            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'slug.unique' => 'Slug đã tồn tại.',
            'status.required' => 'Vui lòng chọn trạng thái.',
        ];
    }
}