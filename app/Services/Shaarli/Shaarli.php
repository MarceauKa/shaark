<?php

namespace App\Services\Shaarli;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Valuestore\Valuestore;

/**
 * @method string getName()
 * @method bool getIsPrivate()
 */
class Shaarli
{
    /** @var string VERSION */
    public const VERSION = '1.2.22';
    /** @var Application $app */
    protected $app;
    /** @var Valuestore $settings */
    protected $settings;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->settings = Valuestore::make(storage_path('settings.json'));

        if ($this->settings->count() === 0) {
            foreach ($this->getSettingsConfig() as $key => $item) {
                $this->settings->put($key, $item['default']);
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

            if ($key === 'custom_background') {
                $this->handleCustomBackground($settings->get('custom_background'));

                continue;
            }

            $this->settings->put($key, $settings->get($key, $item['default']));
        }

        return $this;
    }

    public function cleanSettings(): self
    {
        $defaults = $this->getSettingsConfig();

        foreach ($this->settings->all() as $key => $value) {
            if (false === array_key_exists($key, $defaults)) {
                $this->settings->forget($key);
            }
        }

        return $this;
    }

    public function handleCustomBackground($value): void
    {
        $data = (array)json_decode($value);

        if ($data['type'] === 'gradient') {
            $this->settings->put('custom_background', json_encode($data));
            return;
        } else if ($data['type'] === 'image' && ! empty($data['base64'])) {
            if (false !== preg_match('/data:image\/([a-z]+);.*/i', $data['base64'], $ext)) {
                $ext = $ext[1];
                $base64 = str_replace('data:image/'.$ext.';base64,', '', $data['base64']);
                $file = base64_decode($base64);
                $name = 'custom-background.'.$ext;

                Storage::disk('public')->put($name, $file);
                $url = Storage::disk('public')->url($name);

                $this->settings->put('custom_background', json_encode([
                    'type' => 'image',
                    'file' => $url,
                ]));
            }

            return;
        } else if ($data['type'] === 'none') {
            $this->settings->put('custom_background', $value);
            return;
        }

        return;
    }

    public function getCustomBackgroundCss(): string
    {
        $background = (array)json_decode($this->settings->get('custom_background'));

        if (! array_key_exists('type', $background)) {
            return '';
        }

        if ($background['type'] === 'gradient') {
            return vsprintf("linear-gradient(%sdeg, %s 0%%, %s 100%%)", [
                $background['orientation'],
                $background['start'],
                $background['end'],
            ]);
        }

        if ($background['type'] === 'image') {
            return vsprintf("url(%s)", [
                $background['file'],
            ]);
        }

        return '';
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
