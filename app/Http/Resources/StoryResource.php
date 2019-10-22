<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'date_formated' => $this->created_at->diffForHumans(),
            'tags' => $this->post->tags->pluck('name')->toArray(),
            $this->mergeWhen(Auth::check(), [
                'editable' => true,
                'url_store' => route('api.story.store'),
                'url_edit' => route('story.edit', $this->id),
                'url_update' => route('api.story.update', $this->id),
                'url_delete' => route('api.story.delete', $this->id),
                'url_share' => route('api.share', $this->post->id),
            ])
        ];
    }
}
