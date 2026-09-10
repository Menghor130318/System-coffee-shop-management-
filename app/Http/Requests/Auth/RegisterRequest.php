<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'full_name' => 'required|string|max:100',

            'email' => 'required|email:rfc,dns|unique:users,email',

            'phone' => [
                'nullable',
                'regex:/^(0[3|5|7|8|9])[0-9]{8}$/',
                'unique:users,phone',
            ],

            'password' => 'required|min:6|confirmed',

        ];
    }

    public function messages(): array
    {
        return [

            'full_name.required' => 'Vui lòng nhập họ tên.',

            'email.required' => 'Vui lòng nhập email.',

            'email.email' => 'Email không đúng định dạng.',

            'email.unique' => 'Email đã tồn tại.',

            'password.required' => 'Vui lòng nhập mật khẩu.',

            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',

            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',

            'phone.regex' => 'Số điện thoại không đúng định dạng.',

            'phone.unique' => 'Số điện thoại đã được sử dụng.',

        ];
    }
}
