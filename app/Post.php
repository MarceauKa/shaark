<?php

namespace App;

use App\Concerns\Models\HasTags;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;

/**
 * @method Builder withPrivate(bool|User|Request $private)
 */
class Post extends Model
{
    use HasTags,
        Searchable;

    protected $fillable = [
        'postable_type',
        'postable_id',
        'is_private',
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

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'post_title' => $this->postable->title,
            'post_content' => optional($this->postable)->content,
            'post_date' => $this->created_at->toDateTimeString(),
        ];
    }
}
