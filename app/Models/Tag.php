<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;

    protected $fillable = [
        'name',
    ];

    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public static function findNamedOrCreate(string $name)
    {
        return static::firstOrCreate(['name' => Str::slug($name)]);

    }

    public function getUrlAttribute(): string
    {
        return route('tag', $this->name);
    }

    public function scopeNamed(Builder $query, string $name): Builder
    {
        return $query->where('name', '=', $name);
    }

    public function scopeWithPostsFor(Builder $query, Request $request): Builder
    {
        return $query
            ->withCount(['posts' => function (Builder $query) use ($request) {
                $query->withPrivate($request);
            }])
            ->whereHas('posts', function (Builder $query) use ($request) {
                $query->withPrivate($request);
            }, '>', 0);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
