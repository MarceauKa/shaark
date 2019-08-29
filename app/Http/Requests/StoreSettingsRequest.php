<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:2',
                'max:100',
            ],
            'locale' => [
                'required',
                'in:fr,en',
            ],
            'is_private' => [
                'nullable',
                'in:on,off',
            ],
            'is_dark' => [
                'nullable',
                'in:on,off',
            ]
        ];
    }
}
