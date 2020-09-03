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
            'is_health_check_enabled' => $this->is_health_check_enabled,
            'http_status' => $this->getStatusText($this->http_status),
            'http_status_color' => $this->getStatusColor($this->http_status),
            'http_checked_at' => $this->http_checked_at,
            'permalink' => $this->permalink,
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

    public function getStatusText($status)
    {
        if (is_null($status)) {
            return null;
        }

        if ($status == 200) {
            return 'Healthy (200)';
        }

        if (400 <= $status and $status <= 499) {
            return 'Dead (4xx)';
        }

        return 'Other (3xx, 5xx)';
    }

    public function getStatusColor($status)
    {
        if ($status == 200) {
            return 'success';
        }

        if (400 <= $status and $status <= 499) {
            return 'danger';
        }

        return 'warning';
    }
}
