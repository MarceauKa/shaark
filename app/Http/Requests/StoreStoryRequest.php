<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStoryRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $unique = Rule::unique('stories');

        if ($this->route('id')) {
            $unique->ignore($this->route('id'), 'id');
        }

        return [
            'title' => [
                'required',
                'min:2',
                'max:255',
            ],
            'slug' => [
                'required',
                $unique,
                'max:255',
            ],
            'content' => [
                'nullable',
            ],
            'is_private' => [
                'nullable',
            ],
            'is_pinned' => [
                'nullable',
            ],
            'tags' => [
                'nullable',
                'array',
                'max:10',
            ],
            'tags.*' => [
                'min:1',
                'max:30',
            ],
        ];
    }
}
