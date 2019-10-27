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
    public const VERSION = '1.2.21';
    /** @var Application $app */
    protected $app;
    /** @var Valuestore $settings */
    protected $settings;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->settings = Valuestore::make(storage_path('settings.json'));
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
            'login/secure/*',
            'password/*',
            'logout',
            'shared/*'
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

    public function getSettingsConfig(): array
    {
        return $this->app['config']->get('shaarli.settings');
    }

    public function getSettings(): array
    {
        return array_merge(
            collect($this->getSettingsConfig())
                ->transform(function ($item, $key) {
                    return [
                        'key' => $key,
                        'default' => $item['default'],
                    ];
                })
                ->pluck('default', 'key')
                ->toArray(),
            $this->settings->all()
        );
    }

    public function setSettings(Collection $settings): self
    {
        foreach ($this->getSettingsConfig() as $key => $item) {
            if (is_bool($item['default'])) {
                $this->settings->put($key, $settings->get($key, 'off') == 'on');

                continue;
            }

            if ($key === 'custom_background' || $key === 'custom_background_encoded') {
                if ($this->getCustomBackground() != $settings->get('custom_background')) {
                    $url = $settings->get('custom_background');

                    if (empty($url)) {
                        $this->settings->put('custom_background', null);
                        $this->settings->put('custom_background_encoded', null);

                        continue;
                    }

                    $type = last(explode('.', $url));
                    $value = base64_encode(file_get_contents($url));
                    $encoded = 'data:image/'.$type.';base64,'.$value;

                    $this->settings->put('custom_background', $url);
                    $this->settings->put('custom_background_encoded', $encoded);
                }

                continue;
            }

            $this->settings->put($key, $settings->get($key, $item['default']));
        }

        return $this;
    }

    public function cleanSettings(): self
    {
        $defaults = $this->getSettingsConfig();

        foreach ($this->settings as $key => $value)
        {
            if (false === array_key_exists($key, $defaults)) {
                $this->settings->forget($key);
            }
        }

        return $this;
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) === 'get') {
            $key = Str::snake(substr($name, 3));

            if ($this->settings->has($key)) {
                return $this->settings->get($key);
            }

            if (array_key_exists($key, $this->getSettingsConfig())) {
                $this->settings->put($key, $this->getSettingsConfig()[$key]['default']);
                return $this->settings->get($key);
            }
        }

        if (substr($name, 0, 3) === 'set') {
            $key = Str::snake(substr($name, 3));

            if (array_key_exists($key, $this->getSettingsConfig())) {
                $this->settings->put($key, $arguments[0]);
                return $this;
            }
        }

        throw new \BadMethodCallException("Method {$name} does not exists.");
    }
}
