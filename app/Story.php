<?php

namespace App;

use App\Concerns\Models\Postable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Story extends Model implements Feedable
{
    use Postable;

    protected $table = 'stories';

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute(): string
    {
        return route('story.view', $this->slug);
    }

    public function scopeSlugIs(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    public function toFeedItem()
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => Str::limit($this->content, 130) ?? 'N.C',
            'updated' => $this->updated_at,
            'link' => $this->url,
            'author' => config('app.name'),
        ]);
    }

    public static function getFeedItems()
    {
        return Story::latest()->withPrivate(false)->get();
    }
}
