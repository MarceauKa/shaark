<?php

namespace App;

use App\Concerns\Models\Postable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Chest extends Model
{
    use Postable;

    protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'content' => 'json',
    ];

    public function getHashIdAttribute(): string
    {
        return app('hashid')->encode($this->id);
    }

    public function getPermalinkAttribute(): string
    {
        return route('chest.view', $this->hash_id);
    }

    public function scopeHashIdIs(Builder $query, string $hash): Builder
    {
        return $query->where('id', app('hashid')->decode($hash));
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => collect($this->content)
                ->reject(function ($item) {
                    return false === in_array($item['type'], ['url', 'text']);
                })
                ->pluck('value')
                ->implode("\n"),
        ];
    }
}
