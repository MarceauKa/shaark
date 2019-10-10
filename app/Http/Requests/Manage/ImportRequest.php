<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function rules()
    {
        return [
            'file' => [
                'required',
                'file',
            ],
            'ignore_tags' => [
                'nullable',
            ],
            'get_extras' => [
                'nullable',
            ],
            'refresh_search' => [
                'nullable',
            ],
        ];
    }
}
