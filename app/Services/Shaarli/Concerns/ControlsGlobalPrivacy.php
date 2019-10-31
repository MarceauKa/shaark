<?php

namespace App\Services\Shaarli\Concerns;

use App\Services\Shaarli\Shaarli;
use Illuminate\Http\Request;

/**
 * @mixin Shaarli
 */
trait ControlsGlobalPrivacy
{
    public function authorizeFromRequest(Request $request): bool
    {
        $user = null;

        if ($this->getIsPrivate() === false) {
            return true;
        }

        foreach (['web', 'api'] as $guard) {
            if (! $user) {
                $user = auth($guard)->user();
            }
        }

        if (! empty($user) || $this->requestAuthorizedForGlobalPrivacy($request)) {
            return true;
        }

        return false;
    }

    public function requestAuthorizedForGlobalPrivacy(Request $request): bool
    {
        $excepts = [
            'login',
            'login/secure/*',
            'password/*',
            'logout',
            'shared/*',
            'manifest.json',
            'sw.js',
        ];

        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
