<?php

namespace App;

use App\Concerns\Models\Postable;
use App\Services\ExtraContent\ExtraContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Link extends Model implements Feedable
{
    use Postable;

    protected $fillable = [
        'title',
        'content',
        'extra',
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
