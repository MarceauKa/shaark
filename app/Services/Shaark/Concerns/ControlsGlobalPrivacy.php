<?php

namespace App\Services\Shaark\Concerns;

use App\Services\Shaark\Shaark;
use Illuminate\Http\Request;

/**
 * @mixin Shaark
 */
trait ControlsGlobalPrivacy
{
    public function authorizeFromRequest(Request $request): bool
    {
        $user = null;

        if ($this->getIsPrivate() === false) {
            return true;
        }

        $user = $this->getRequestUser();

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
            'robots.txt',
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
