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

    public function getCreatedAtFormatedAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

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

    public function getContentAttribute($value)
    {
        try {
            $content = decrypt($value, false);
        } catch (\Exception $e) {
            $content = $value;
        }

        return json_decode($content);
    }

    public function setContentAttribute($value)
    {
        try {
            $content = encrypt(json_encode($value), false);
        } catch (\Exception $e) {
            $content = json_encode($value);
        }

        $this->attributes['content'] = $content;
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => collect($this->content)
                ->reject(function ($item) {
                    return false === in_array($item->type, ['url', 'text']);
                })
                ->pluck('value')
                ->implode("\n"),
        ];
    }
}
