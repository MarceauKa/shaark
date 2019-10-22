<?php

namespace App;

use App\Concerns\Models\HasTags;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'user_id',
        'created_at',
    ];
    protected $casts = [
        'is_private' => 'bool',
    ];

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(Share::class);
    }

    public function getCreatedAtFormatedAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function scopeWithPrivate(Builder $query, $user = null): Builder
    {
        if ($user instanceof Request) {
            $user = $user->user();
        }

        if (empty($user)) {
            return $query->where('is_private', 0);
        }

        if ($user->is_admin === false) {
            return $query
                ->where('is_private', 0)
                ->orWhere(function ($query) use ($user) {
                    return $query
                        ->where('is_private', 1)
                        ->where('user_id', $user->id);
                });
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
