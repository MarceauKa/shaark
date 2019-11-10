<?php

namespace App;

use App\Concerns\Models\Postable;
use App\Services\Shaarli\Shaarli;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
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

    public function canDownloadArchive(): bool
    {
        if ($this->post->is_private
            && auth()->check() === false) {
            return false;
        }

        if (app('shaarli')->getPrivateDownload() === true
            && auth()->check() === false) {
            return false;
        }

        return true;
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(self::$mimes)
            ->useDisk('albums');
    }

    public function registerMediaConversions(Media $media = null)
    {
        /** @var Shaarli $shaarli */
        $shaarli = app('shaarli');
        $conversion = $this->addMediaConversion('thumb');

        if ($shaarli->getImagesThumbFormat() === 'square') {
            $conversion->fit(Manipulations::FIT_CROP, 300, 300);
        }

        if ($shaarli->getImagesThumbFormat() === 'original') {
            $conversion->fit(Manipulations::FIT_CONTAIN, 300, 300);
        }

        if ($shaarli->getImagesThumbQueue() === false) {
            $conversion->nonQueued();
        }
    }
}
