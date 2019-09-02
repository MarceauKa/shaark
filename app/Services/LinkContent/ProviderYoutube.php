<?php

namespace App\Services\LinkContent;

class ProviderYoutube extends BaseProvider
{
    /** @var string $regex */
    public $regex = '/(?:https:\/\/)?(?:www\.)?(?:youtube.com|youtu.be)(?:\/watch\?v\=|\/embed\/|\/)([a-z0-9\-]+)/i';

    public function canPreview(): bool
    {
        return preg_match($this->regex, $this->url) != false;
    }

    public function getPreview(): ?string
    {
        preg_match($this->regex, $this->url, $matches);
        $id = $matches[1];

        if ($id) {
            return '<iframe width="100%" src="https://www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe>';
        }

        return null;
    }
}
