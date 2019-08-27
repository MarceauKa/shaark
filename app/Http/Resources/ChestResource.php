<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'permalink' => $this->permalink,
            'is_private' => true,
            'tags' => $this->post->tags->pluck('name')->toArray()
        ];
    }
}
