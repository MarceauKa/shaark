<?php

namespace App\Services\Shaarli;

use App\Services\Shaarli\Concerns\ControlsGlobalPrivacy;
use App\Services\Shaarli\Concerns\ControlsSettings;
use App\Services\Shaarli\Concerns\HandleCustomSettings;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Spatie\Valuestore\Valuestore;

class Shaarli
{
    use ControlsGlobalPrivacy,
        ControlsSettings,
        HandleCustomSettings;

    /** @var string VERSION */
    public const VERSION = '1.2.24';
    /** @var Application $app */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->settings = Valuestore::make(storage_path('settings.json'));

        $this->validateDefaultSettings();
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
