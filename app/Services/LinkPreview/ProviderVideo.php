<?php

namespace App\Services\LinkPreview;

class ProviderVideo extends BaseProvider
{
    /** @var string $regex */
    public $regex = '/.*\.(mp4|mpg|mpeg)$/i';

    public function canPreview(): bool
    {
        return preg_match($this->regex, $this->url) != false;
    }

    public function getPreview(): ?string
    {
        return str_replace('{url}', $this->url, '<video src="{url}" controls width="100%" height="auto"></video>');
    }

}
