<?php

namespace App\Services\Shaarli;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Valuestore\Valuestore;

/**
 * @method string getName()
 * @method bool getIsPrivate()
 */
class Shaarli
{
    /** @var string VERSION */
    public const VERSION = '1.0.0';
    /** @var Application $app */
    protected $app;
    /** @var Valuestore $settings */
    protected $settings;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->settings = Valuestore::make(storage_path('settings.json'));

        foreach ($this->app['config']->get('shaarli') as $key => $item) {
            if ($this->settings->has($key) === false) {
                $this->settings->put($key, $item);
            }
        }
    }

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
            'password/*',
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

    public function getSettings(): array
    {
        return $this->settings->all();
    }

    public function setSettings(Collection $settings): void
    {
        $this->settings->put('name', $settings->get('name'));
        $this->settings->put('locale', $settings->get('locale'));
        $this->settings->put('is_private', $settings->get('is_private') == 'on');
        $this->settings->put('is_dark', $settings->get('is_dark') == 'on');
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) === 'get') {
            $key = Str::snake(substr($name, 3));

            if ($this->settings->has($key)) {
                return $this->settings->get($key);
            }

            if (array_key_exists($key, config('shaarli'))) {
                $this->settings->put($key, config('shaarli')[$key]);
                return $this->settings->get($key);
            }
        }

        throw new \BadMethodCallException("Method {$name} does not exists.");
    }
}
