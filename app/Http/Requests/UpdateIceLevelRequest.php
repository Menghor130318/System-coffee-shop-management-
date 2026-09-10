<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIceLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => [
                "required",
                "string",
                "max:50",
                Rule::unique("ice_levels")
                    ->ignore($this->route("ice_level")),
            ],

            "status" => "required|boolean",
        ];
    }
}
