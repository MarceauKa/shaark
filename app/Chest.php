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
        return hashid_encode($this->id);
    }

    public function getPermalinkAttribute(): string
    {
        return route('chest.view', $this->hash_id);
    }

    public function scopeHashIdIs(Builder $query, string $hash): Builder
    {
        return $query->where('id', hashid_decode($hash));
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
        ];
    }
}
