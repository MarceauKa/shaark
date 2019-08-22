<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Link extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'url' => '#',
            'created_at' => $this->created_at,
        ];
    }
}
