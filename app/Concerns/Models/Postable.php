<?php

namespace App\Concerns\Models;

use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\Request;

/**
 * @property string $title
 * @property string $content
 * @method Builder withPrivate(bool|User|Request $private)
 */
trait Postable
{
    public function post(): MorphOne
    {
        return $this->morphOne(Post::class, 'postable');
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
            return $query->whereHas('post', function (Builder $query) {
                $query->where('is_private', 0);
            });
        }

        return $query;
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
