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
            'http_status' => $this->http_status,
            'http_status_color' => $this->getHttpStatusColor($this->http_status),
            'http_checked_at_formated' => $this->http_checked_at ? $this->http_checked_at->diffForHumans() : '',
            'permalink' => $this->permalink,
            'is_watched' => $this->is_watched,
            'is_private' => $this->post->is_private,
            'is_pinned' => $this->post->is_pinned,
            'preview' => $this->preview,
            'date_formated' => $this->created_at->diffForHumans(),
            'tags' => $this->post->tags->pluck('name')->toArray(),
            $this->mergeWhen(Auth::check(), [
                'editable' => true,
                'url_store' => route('api.link.store'),
                'url_edit' => route('link.edit', $this->id),
                'url_update' => route('api.link.update', $this->id),
                'url_delete' => route('api.link.delete', $this->id),
                'url_archive' => route('api.link.archive', $this->id),
                'url_share' => route('api.share', $this->post->id),
            ]),
            $this->mergeWhen($this->resource->canDownloadArchive(), [
               'url_download' => route('link.archive.download', $this->id),
            ])
        ];
    }

    protected function getHttpStatusColor($status): ?string
    {
        $range = (int)floor((int)$status / 100);

        switch ($range) {
            case 3:
                return 'info';
            case 4:
                return 'warning';
            case 5:
                return 'danger';
            default:
                return null;
        }
    }
}
