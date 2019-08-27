<?php

namespace App\Services\ExtraContent;

class ProviderImage extends BaseProvider
{
    /** @var string $regex */
    public $regex = '/(?:https:\/\/)(?:.*)\.(?:png|jpg|jpeg|gif)/i';

    public function check(): bool
    {
        return preg_match($this->regex, $this->url) != false;
    }

    public function get(): ?string
    {
        if (preg_match($this->regex, $this->url)) {
            return str_replace('{url}', $this->url, '<img src="{url}" class="img-fluid" />');
        }

        return null;
    }

}
