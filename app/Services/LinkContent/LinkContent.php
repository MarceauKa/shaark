<?php

namespace App\Services\LinkContent;

class LinkContent
{
    /** @var array $providers */
    public $providers = [
        ProviderYoutube::class,
        ProviderSoundcloud::class,
        ProviderImgur::class,
        ProviderImage::class,
        ProviderVideo::class,
        FallbackProvider::class,
    ];
    /** @var string $url */
    public $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function preview(string $url): ?string
    {
        $provider = (new static($url))->getProviderForPreview();

        if ($provider) {
            return $provider->getPreview();
        }

        return null;
    }

    public static function archive(string $url): ?string
    {
        $provider = (new static($url))->getProviderForArchive();

        if ($provider && $provider->canArchive()) {
            return $provider->makeArchive();
        }

        return null;
    }

    public function getProviderForPreview(): ?BaseProvider
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

    public function getProviderForArchive(): ?BaseProvider
    {
        foreach ($this->providers as $provider)
        {
            /** @var BaseProvider $provider */
            $provider = new $provider($this->url);

            if ($provider->canArchive()) {
                return $provider;
            }
        }

        return null;
    }
}
