<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:categories,name',
            'slug' => 'nullable|max:255|unique:categories,slug',
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