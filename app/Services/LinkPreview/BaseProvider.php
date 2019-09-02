<?php

namespace App\Services\LinkPreview;

abstract class BaseProvider
{
    /** @var string $url */
    public $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    abstract public function canPreview(): bool;

    abstract public function getPreview(): ?string;

    public function makeRequest(?string $url): ?string
    {
        $url = $url ?? $this->url;

        try {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $content = curl_exec($curl);
            curl_close($curl);

            return $content;
        } catch (\Exception $e) {
            unset($e);
        }

        return null;
    }
}
