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
            'private_archive' => [
                'nullable',
                'in:on,off',
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
