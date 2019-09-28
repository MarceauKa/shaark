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
            ],
            'homepage_alt' => [
                'nullable',
                'in:on,off',
            ],
            'secure_login' => [
                'nullable',
                'in:on,off',
            ],
            'secure_code_expires' => [
                'required',
                'numeric',
                'min:5',
                'max:300',
            ],
            'secure_code_length' => [
                'required',
                'numeric',
                'min:4',
                'max:12',
            ],
            'link_archive_media' => [
                'nullable',
                'in:on,off',
            ],
            'link_archive_pdf' => [
                'nullable',
                'in:on,off',
            ],
            'youtube_dl_bin' => [
                'required',
            ],
            'node_bin' => [
                'required',
            ],
        ];
    }
}
