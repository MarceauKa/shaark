<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @method SecureLogin isNotExpired()
 */
class SecureLogin extends Model
{
    public $primaryKey = 'token';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['expires_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIsNotExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '>=', Carbon::now()->toDateTimeString());
    }

    public function getRouteKeyName(): string
    {
        return 'token';
    }

    public static function createForUser(User $user): self
    {
        $code_length = app('shaarli')->getSecureCodeLength();
        $expire_minutes = app('shaarli')->getSecureCodeExpires();

        $model = new static();
        $model->user_id = $user->id;
        $model->token = Str::random(100);
        $model->code = Str::random($code_length);
        $model->expires_at = Carbon::now()->addMinutes($expire_minutes);
        $model->save();

        return $model;
    }
}
