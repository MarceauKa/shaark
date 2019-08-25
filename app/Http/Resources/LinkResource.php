<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'tags' => $this->tags->pluck('name')->toArray(),
            'url' => $this->permalink,
            'created_at' => $this->created_at,
        ];
    }
}
