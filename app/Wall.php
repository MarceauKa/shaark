<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * @property array $restrict_tags
 * @property array $restrict_cards
 * @property array $appearance
 * @property bool is_default
 * @property bool is_private
 */
class Wall extends Model
{
    const APPEARANCE_DEFAULT = [
        'columns' => 2,
        'show_tags' => true,
        'compact' => false,
    ];
    /** @var array $fillable */
    protected $fillable = [
        'title',
        'slug',
        'is_default',
        'is_private',
        'restrict_tags',
        'restrict_cards',
        'appearance',
    ];
    /** @var array $casts */
    protected $casts = [
        'is_default' => 'bool',
        'is_private' => 'bool',
        'restrict_tags' => 'array',
        'restrict_cards' => 'array',
        'appearance' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function walls(): HasMany
    {
        return $this->hasMany(Wall::class);
    }

    public function setAppearanceAttribute($value)
    {
        if ($value instanceof Request) {
            $value = $value->get('appearance', self::APPEARANCE_DEFAULT);
        }

        $this->attributes['appearance'] = json_encode($value);
    }

    public function scopeIsDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }

    public function scopeSlugIs(Builder $query, string $slug = null): Builder
    {
        if (empty($slug)) {
            return $this->scopeIsDefault($query);
        }

        return $query->where('slug', $slug);
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
}
