<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LinkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'url' => $this->url,
            'permalink' => $this->permalink,
            'is_private' => $this->post->is_private,
            'preview' => $this->preview,
            'date_formated' => $this->created_at->diffForHumans(),
            'tags' => $this->post->tags->pluck('name')->toArray(),
            $this->mergeWhen(Auth::check(), [
                'editable' => true,
                'url_store' => route('api.link.store'),
                'url_edit' => route('link.edit', $this->id),
                'url_update' => route('api.link.update', $this->id),
                'url_delete' => route('api.link.delete', $this->id),
                'url_archive' => route('link.archive.form', $this->id),
                'url_preview' => route('api.link.preview', $this->id),
                'url_share' => route('api.share', $this->post->id),
            ]),
            $this->mergeWhen($this->resource->canDownloadArchive(), [
               'url_download' => route('link.archive.download', [$this->id, csrf_token()]),
            ])
        ];
    }
}
