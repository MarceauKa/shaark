<?php

namespace App\Services\LinkContent;

class ProviderImage extends BaseProvider
{
    /** @var string $regex */
    public $regex = '/(?:https:\/\/)(?:.*)\.(?:png|jpg|jpeg|gif)/i';

    public function canPreview(): bool
    {
        return preg_match($this->regex, $this->url) != false;
    }

    public function getPreview(): ?string
    {
        if (preg_match($this->regex, $this->url)) {
            return str_replace('{url}', $this->url, '<img src="{url}" class="img-fluid" />');
        }

        return null;
    }
}
