<?php

namespace App;

use App\Concerns\Models\HasTags;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

/**
 * @method Builder|Post withPrivate(bool|User|Request $private)
 * @method Builder|Post withoutChests()
 */
class Post extends Model
{
    use HasTags,
        Searchable;

    protected $fillable = [
        'postable_type',
        'postable_id',
        'is_private',
        'created_at',
    ];

    protected $casts = [
        'is_private' => 'bool',
    ];

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeWithPrivate(Builder $query, $private = false): Builder
    {
        if ($private instanceof Request) {
            $private = $private->user() instanceof User;
        }

        if ($private instanceof User) {
            $private = true;
        }

        if ($private === false) {
            return $query->where('is_private', 0);
        }

        return $query;
    }

    public function scopeWithoutChests(Builder $query): Builder
    {
        return $query->where('postable_type', '!=', Chest::class);
    }

    public function scopeOnlyLinks(Builder $query): Builder
    {
        return $query->where('postable_type', '=', Link::class);
    }

    public function scopeLinksWithArchive(Builder $query): Builder
    {
        return $query->whereHasMorph('postable', Link::class, function (Builder $query) {
            return $query->whereNotNull('archive');
        });
    }

    public function toSearchableArray()
    {
        return array_merge([
            'id' => $this->id,
            'date' => $this->created_at->toDateTimeString(),
        ], $this->postable->toSearchableArray());
    }
}
