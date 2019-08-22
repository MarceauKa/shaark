<?php

namespace App\Services\ExtraContent;

class ExtraContent
{
    /** @var array $providers */
    public $providers = [
        ProviderYoutube::class,
        ProviderSoundcloud::class,
    ];
    /** @var string $url */
    public $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function get(string $url): ?string
    {
        $provider = (new static($url))->getProvider();

        if ($provider) {
            return $provider->get();
        }

        return null;
    }

    public function getProvider(): ?BaseProvider
    {
        foreach ($this->providers as $provider)
        {
            /** @var BaseProvider $provider */
            $provider = new $provider($this->url);

            if ($provider->check()) {
                return $provider;
            }
        }

        return null;
    }
}
