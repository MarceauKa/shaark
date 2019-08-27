<?php

namespace App\Http\Resources;

use App\Chest;
use App\Link;
use App\Story;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource->postable instanceof Link) {
            $content = [
                'title' => $this->postable->title,
                'content' => $this->postable->content,
                'url' => $this->postable->url,
                'type' => 'link',
            ];
        } elseif ($this->resource->postable instanceof Story) {
            $content = [
                'title' => $this->postable->title,
                'slug' => $this->postable->slug,
                'content' => $this->postable->content,
                'type' => 'story',
            ];
        } elseif ($this->resource->postable instanceof Chest) {
            $content = [
                'title' => $this->postable->title,
                'type' => 'chest',
            ];
        }

        return array_merge($content, [
            'tags' => $this->tags->pluck('name')->toArray(),
            'is_private' => $this->is_private,
            'created_at' => $this->created_at,
        ]);
    }
}
