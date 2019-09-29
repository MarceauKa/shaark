<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'url' => $this->permalink,
            'permalink' => $this->permalink,
            'is_private' => true,
            'date_formated' => $this->created_at->diffForHumans(),
            'tags' => $this->post->tags->pluck('name')->toArray(),
            $this->mergeWhen(Auth::check(), [
                'editable' => true,
                'url_store' => route('api.chest.store'),
                'url_edit' => route('chest.edit', $this->id),
                'url_update' => route('api.chest.update', $this->id),
                'url_delete' => route('api.chest.delete', $this->id),
            ])
        ];
    }
}
