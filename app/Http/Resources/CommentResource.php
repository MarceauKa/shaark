<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comment_id' => $this->comment_id,
            'content' => $this->content,
            'name' => $this->user->name,
            'is_visible' => $this->is_visible,
            'date_formated' => $this->created_at->diffForHumans(),
        ];
    }
}
