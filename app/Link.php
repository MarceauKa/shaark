<?php

namespace App;

use App\Concerns\Models\HasTags;
use App\Services\ExtraContent\ExtraContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Link extends Model implements Feedable
{
    use HasTags,
        Searchable;

    protected $fillable = [
        'title',
        'content',
        'extra',
        'url',
        'is_private',
    ];

    protected $appends = [
        'permalink',
    ];

    protected $casts = [
        'is_private' => 'bool',
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

    public function scopeWithPrivate(Builder $query, bool $private = false): Builder
    {
        if ($private === false) {
            return $query->where('is_private', 0);
        }

        return $query;
    }

    public function scopeIsPrivate(Builder $query): void
    {
        $query->where('is_private', true);
    }

    public function findExtra(): self
    {
        $extra = ExtraContent::get($this->url);

        if ($extra) {
            $this->attributes['extra'] = $extra;
            $this->save();
        }

        return $this;
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
