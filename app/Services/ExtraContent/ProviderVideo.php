<?php

namespace App\Services\ExtraContent;

class ProviderVideo extends BaseProvider
{
    /** @var string $regex */
    public $regex = '/.*\.(mp4|mpg|mpeg)$/i';

    public function check(): bool
    {
        return preg_match($this->regex, $this->url) != false;
    }

    public function get(): ?string
    {
        return str_replace('{url}', $this->url, '<video src="{url}" controls width="100%" height="auto"></video>');
    }

}
