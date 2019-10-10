<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'min:2',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('id'), 'id'),
            ],
            'password' => [
                'nullable',
                'confirmed',
                'min:8',
            ]
        ];

        if (auth()->user()->id == $this->route('id')) {
            $rules['is_admin'] = [
                'required',
                'in:1'
            ];
        } else {
            $rules['is_admin'] = [
                'nullable',
            ];
        }

        return $rules;
    }
}
