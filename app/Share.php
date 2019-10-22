<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @method Builder tokenIs(string $token)
 */
class Share extends Model
{
    protected $fillable = [
        'sharable_type',
        'sharable_id',
        'token',
        'expires_at',
    ];
    protected $dates = [
        'expires_at',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function getUrlAttribute(): string
    {
        return route('share', $this->token);
    }

    public function scopePostIs(Builder $query, int $id): Builder
    {
        return $query->where('post_id', $id);
    }

    public function scopeTokenIs(Builder $query, string $token): Builder
    {
        return $query->where('token', $token);
    }

    public function generateToken()
    {
        return Str::random(64);
    }
}
