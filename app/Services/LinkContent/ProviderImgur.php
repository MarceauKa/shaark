<?php

namespace App\Services\LinkContent;

class ProviderImgur extends BaseProvider
{
    /** @var string $regex */
    public $regex = '/(?:https:\/\/)?imgur\.com\/(?:gallery|a)\/([a-z0-9\-]+)/i';

    public function canPreview(): bool
    {
        return preg_match($this->regex, $this->url) != false;
    }

    public function getPreview(): ?string
    {
        preg_match($this->regex, $this->url, $matches);
        $id = $matches[1];

        if ($id) {
            return str_replace('{id}', $id, '<blockquote class="imgur-embed-pub" lang="en" data-id="a/{id}"></blockquote><script async src="//s.imgur.com/min/embed.js" charset="utf-8"></script>');
        }

        return null;
    }

}
