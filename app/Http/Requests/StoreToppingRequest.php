<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreToppingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string|max:50|unique:toppings,name",

            "price" => "required|numeric|min:0",

            "status" => "required|boolean",
        ];
    }
}
