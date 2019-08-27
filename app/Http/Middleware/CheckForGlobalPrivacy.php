<?php

namespace App\Http\Middleware;

use Closure;

class CheckForGlobalPrivacy
{
    /** @var array $except */
    private $except = [
        'login',
        'password/*',
    ];

    public function handle($request, Closure $next)
    {
        $user = null;

        foreach (['web', 'api'] as $guard) {
            if (! $user) {
                $user = auth($guard)->user();
            }
        }

        if ($user || false === $this->globalPrivacyEnabled() || $this->inExceptArray($request)) {
            return $next($request);
        }

        return redirect()->route('login');
    }

    protected function globalPrivacyEnabled(): bool
    {
        return config('app.private', false);
    }

    protected function inExceptArray($request): bool
    {
        foreach ($this->except as $except) {
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
