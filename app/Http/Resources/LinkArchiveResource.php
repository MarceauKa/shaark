<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\Helpers\Format;

class LinkArchiveResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'permalink' => $this->permalink,
            'filename' => $this->archive,
            'size' => Format::humanReadableSize(Storage::disk('archives')->size($this->archive)),
            'extension' => last(explode('.', $this->archive)),
            'date_formated' => $this->created_at->diffForHumans(),
            'url_archive' => route('api.link.archive', $this->id),
            'url_download' => route('link.archive.download', $this->id),
        ];
    }
}
