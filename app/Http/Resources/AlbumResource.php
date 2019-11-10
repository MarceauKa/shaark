<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;

class AlbumResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'permalink' => $this->permalink,
            'images' => $this->getAlbumImages(),
            'is_private' => $this->post->is_private,
            'is_pinned' => $this->post->is_pinned,
            'date_formated' => $this->created_at->diffForHumans(),
            'tags' => $this->post->tags->pluck('name')->toArray(),
            $this->mergeWhen(Auth::check(), [
                'editable' => true,
                'url_store' => route('api.album.store'),
                'url_edit' => route('album.edit', $this->id),
                'url_update' => route('api.album.update', $this->id),
                'url_delete' => route('api.album.delete', $this->id),
                'url_share' => route('api.share', $this->post->id),
            ]),
            $this->mergeWhen($this->resource->canDownloadArchive(), [
                'url_download' => route('album.download', $this->id),
            ])
        ];
    }

    protected function getAlbumImages(): array
    {
        return $this
            ->getMedia('images')
            ->transform(function ($item) {
                /** @var Media $item */
                return [
                    'name' => $item->name,
                    'size' => $item->human_readable_size,
                    'mime' => $item->mime_type,
                    'order' => $item->order_column,
                    'url_full' => $item->getFullUrl(),
                    'url_thumb' => $item->hasGeneratedConversion('thumb') ? $item->getFullUrl('thumb') : null,
                ];
            })
            ->toArray();
    }
}
