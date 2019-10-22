<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShareResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'url' => $this->url,
            'expires_at' => $this->expires_at->diffForHumans(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
