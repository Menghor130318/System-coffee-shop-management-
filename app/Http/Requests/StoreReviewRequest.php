<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'rating' => [
                'required',
                'integer',
                'between:1,5'
            ],

            'comment' => [
                'nullable',
                'string',
                'max:1000'
            ],

        ];
    }
}
