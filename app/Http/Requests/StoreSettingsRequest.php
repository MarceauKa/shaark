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
        $config = collect(app('shaark')->getSettingsConfig());

        return $config->transform(function ($item, $key) {
            return [
                'key' => $key,
                'rules' => $item['rules'],
            ];
        })->pluck('rules', 'key')->toArray();
    }
}
