<?php

namespace App;

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

    public static function generateApiToken(): string
    {
        return Str::random(128);
    }
}
