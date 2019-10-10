<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'created_at' => $this->created_at,
            $this->mergeWhen(Auth::check(), function () {
                return [
                    'url_update' => route('api.manage.users.update', $this->id),
                    'url_delete' => route('api.manage.users.delete', $this->id),
                ];
            })
        ];
    }
}
