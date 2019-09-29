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
                'store_url' => route('api.chest.store'),
                'edit_url' => route('chest.edit', $this->id),
                'update_url' => route('api.chest.update', $this->id),
                'delete_url' => route('api.chest.delete', $this->id),
            ])
        ];
    }
}
