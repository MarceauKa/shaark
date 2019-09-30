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
    public const VERSION = '1.2.8';
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
        return [
            'name' => [
                'default' => config('app.name'),
                'rules' => ['required', 'min:2', 'max:100']
            ],
            'locale' => [
                'default' => config('app.locale'),
                'rules' => ['required', 'in:fr,en']
            ],
            'is_private' => [
                'default' => false,
                'rules' => ['nullable', 'in:on,off']
            ],
            'is_dark' => [
                'default' => false,
                'rules' => ['nullable', 'in:on,off']
            ],
            'homepage_alt' => [
                'default' => false,
                'rules' => ['nullable', 'in:on,off']
            ],
            'custom_background' => [
                'default' => null,
                'rules' => ['nullable', 'url']
            ],
            'custom_background_encoded' => [
                'default' => null,
                'rules' => ['nullable']
            ],
            'private_archive' => [
                'default' => false,
                'rules' => ['nullable', 'in:on,off']
            ],
            'secure_login' => [
                'default' => false,
                'rules' => ['nullable', 'in:on,off']
            ],
            'secure_code_expires' => [
                'default' => 30,
                'rules' => ['required', 'numeric', 'min:5', 'max:300']
            ],
            'secure_code_length' => [
                'default' => 8,
                'rules' => ['required', 'numeric', 'min:4', 'max:12']
            ],
            'link_archive_pdf' => [
                'default' => true,
                'rules' => ['nullable', 'in:on,off']
            ],
            'link_archive_media' => [
                'default' => true,
                'rules' => ['nullable', 'in:on,off']
            ],
            'node_bin' => [
                'default' => '/usr/bin/node',
                'rules' => ['required']
            ],
            'youtube_dl_bin' => [
                'default' => '/usr/bin/youtube-dl',
                'rules' => ['required']
            ],
        ];
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

    public function setSettings(Collection $settings): void
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

        throw new \BadMethodCallException("Method {$name} does not exists.");
    }
}
