<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Lab404\AuthChecker\Interfaces\HasLoginsAndDevicesInterface;
use Lab404\AuthChecker\Models\HasLoginsAndDevices;

class User extends Authenticatable implements HasLoginsAndDevicesInterface
{
    use Notifiable,
        HasLoginsAndDevices;

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'bool',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function scopeIsAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', 1);
    }

    public static function generateApiToken(): string
    {
        return Str::random(128);
    }
}
