<?php

namespace App;

use App\Concerns\Models\Postable;
use App\Services\LinkContent\LinkContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Link extends Model implements Feedable
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
        return hashid_encode($this->id);
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
        return $query->where('id', hashid_decode($hash));
    }

    public function updatePreview(): self
    {
        $preview = LinkContent::preview($this->url);

        if ($preview) {
            $this->attributes['preview'] = $preview;
            $this->save();
        }

        return $this;
    }

    public function createArchive(): self
    {
        $file = LinkContent::archive($this->url);

        if (Storage::disk('archives')->exists($file)) {
            $this->attributes['archive'] = $file;
            $this->save();
        }

        return $this;
    }

    public function hasArchive(): bool
    {
        return !empty($this->archive);
    }

    public function toFeedItem()
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => Str::limit($this->content, 130) ?? 'N.C',
            'updated' => $this->updated_at,
            'link' => $this->permalink,
            'author' => config('app.name'),
        ]);
    }

    public static function getFeedItems()
    {
        return Link::latest()->withPrivate(false)->get();
    }
}
