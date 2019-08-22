<?php

namespace App;

use App\Services\ExtraContent\ExtraContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class Link extends Model
{
    use HasTags;

    protected $fillable = [
        'title',
        'content',
        'extra',
        'url',
        'is_private',
    ];

    protected $casts = [
        'is_private' => 'bool',
    ];

    public function getHashIdAttribute(): string
    {
        return hashid_encode($this->id);
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

    public function sharingBookmarkCode(): string
    {
        return vsprintf("javascript:(function(){var url=location.href; window.open('%s?url=' + encodeURIComponent(url), '_blank', '%s');})();", [
            route('link.create'),
            'menubar=no,height=390,width=600,toolbar=no,scrollbars=no,status=no,dialog=1'
        ]);
    }
}
