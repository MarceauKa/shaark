<?php

namespace App\Services\LinkPreview;

class LinkPreview
{
    /** @var array $providers */
    public $providers = [
        ProviderYoutube::class,
        ProviderSoundcloud::class,
        ProviderImgur::class,
        ProviderImage::class,
        ProviderVideo::class,
    ];
    /** @var string $url */
    public $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function preview(string $url): ?string
    {
        $provider = (new static($url))->getProvider();

        if ($provider) {
            return $provider->getPreview();
        }

        return null;
    }

    public function getProvider(): ?BaseProvider
    {
        foreach ($this->providers as $provider)
        {
            /** @var BaseProvider $provider */
            $provider = new $provider($this->url);

            if ($provider->canPreview()) {
                return $provider;
            }
        }

        return null;
    }
}
