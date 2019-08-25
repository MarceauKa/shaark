<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAccount extends FormRequest
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
                'max:60'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:100'
            ]
        ];
    }
}
