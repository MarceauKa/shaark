<?php

namespace App;

use App\Concerns\Models\Postable;
use App\Services\LinkPreview\LinkPreview;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Link extends Model
{
    use Postable;

    protected $fillable = [
        'title',
        'content',
        'preview',
        'archive',
        'url',
    ];
    protected $appends = [
        'permalink',
    ];

    public function getHashIdAttribute(): string
    {
        return app('hashid')->encode($this->id);
    }

    public function getPermalinkAttribute(): string
    {
        return route('link.view', $this->hash_id);
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->attributes['url'])) {
            return $this->permalink;
        }

        return $this->attributes['url'];
    }

    public function scopeHashIdIs(Builder $query, string $hash): Builder
    {
        return $query->where('id', app('hashid')->decode($hash));
    }

    public function updatePreview(): self
    {
        $preview = LinkPreview::preview($this->url);

        if ($preview) {
            $this->attributes['preview'] = $preview;
            $this->save();
        }

        return $this;
    }

    public function hasArchive(): bool
    {
        return !empty($this->archive) && Storage::disk('archives')->exists($this->archive);
    }

    public function canDownloadArchive(): bool
    {
        if (false === $this->hasArchive()) {
            return false;
        }

        if ($this->post->is_private
            && auth()->check() === false) {
            return false;
        }

        if (app('shaarli')->getPrivateArchive() === true
            && auth()->check() === false) {
            return false;
        }

        return true;
    }
}
