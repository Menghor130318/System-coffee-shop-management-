<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'full_name' => 'required|string|max:100',

            'phone' => [
                'nullable',
                'regex:/^(0|\+84)[0-9]{9}$/',
                
            ],

            'address' => 'nullable|string|max:255',

        ];
    }

    public function messages(): array
    {
        return [

            'full_name.required' => 'Vui lòng nhập họ tên.',

            'phone.regex' => 'Số điện thoại không hợp lệ.',

            'phone.unique' => 'Số điện thoại đã được sử dụng.',

        ];
    }
}
