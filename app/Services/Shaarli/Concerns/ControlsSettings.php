<?php

namespace App\Services\Shaarli\Concerns;

use App\Services\Shaarli\Shaarli;
use Illuminate\Support\Collection;
use Spatie\Valuestore\Valuestore;

/**
 * @mixin Shaarli
 * @method string getName()
 * @method string getLocale()
 * @method bool getIsPrivate()
 * @method bool getIsDark()
 * @method bool getHomeShowTags()
 * @method bool getHomeShowChests()
 * @method bool getCompactCardslist()
 * @method bool getColumnsCount()
 * @method string getCustomBackground()
 * @method string getCustomIcon()
 * @method bool getPrivateArchive()
 * @method bool getSecureLogin()
 * @method bool getBackupEnabled()
 * @method bool getBackupOnlyDatabase()
 * @method bool getBackupPeriod()
 * @method bool getImagesOriginalResize()
 * @method int getImagesOriginalResizeWidth()
 * @method string getImagesThumbFormat()
 * @method bool getImagesThumbQueue()
 */
trait ControlsSettings
{
    /** @var Valuestore $settings */
    protected $settings;

    public function getSettingsConfig(): array
    {
        return $this->app['config']->get('shaarli.settings');
    }

    public function validateDefaultSettings(): void
    {
        if ($this->settings->count() === 0) {
            foreach ($this->getSettingsConfig() as $key => $item) {
                $this->settings->put($key, $item['default']);
            }
        }
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
            if ($key === 'custom_background') {
                $this->handleCustomBackground($settings->get('custom_background'));
                continue;
            }

            if ($key === 'custom_icon') {
                $this->handleCustomIcon($settings->get('custom_icon'));
                continue;
            }

            if (is_bool($item['default'])) {
                $this->settings->put($key, $settings->get($key, 'off') == 'on');
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
}
