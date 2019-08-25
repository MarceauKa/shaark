<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;

    protected $fillable = [
        'name',
    ];

    public function links(): MorphToMany
    {
        return $this->morphedByMany(Link::class, 'taggable');
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
}
