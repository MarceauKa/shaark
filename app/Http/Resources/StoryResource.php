<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'url' => $this->url,
            'is_private' => $this->post->is_private,
            'tags' => $this->post->tags->pluck('name')->toArray()
        ];
    }
}
