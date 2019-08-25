<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateUserPassword extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
            ],
            'current_password' => [
                'required',
                'different:new_password',
                function ($attribute, $value, $fail) {
                    if (false === Hash::check($value, auth()->user()->getAuthPassword())) {
                        $fail(__('Current password is invalid.'));
                    }
                }
            ]
        ];
    }
}
