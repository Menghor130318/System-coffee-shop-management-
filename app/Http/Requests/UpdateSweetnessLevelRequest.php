<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSweetnessLevelRequest extends FormRequest
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
                Rule::unique("sweetness_levels")
                    ->ignore($this->route("sweetness_level")),
            ],

            "status" => "required|boolean",
        ];
    }
}
