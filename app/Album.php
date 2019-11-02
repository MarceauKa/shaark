<?php

namespace App;

use App\Concerns\Models\Postable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Album extends Model implements HasMedia
{
    use Postable,
        HasMediaTrait;

    static public $mimes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'image/bmp',
    ];
    protected $fillable = [
        'title',
        'content',
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
        return route('album.view', $this->hash_id);
    }

    public function scopeHashIdIs(Builder $query, string $hash): Builder
    {
        return $query->where('id', app('hashid')->decode($hash));
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(self::$mimes)
            ->useDisk('albums');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }
}
