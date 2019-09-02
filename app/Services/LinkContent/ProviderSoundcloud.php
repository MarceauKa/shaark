<?php

namespace App\Services\LinkContent;

class ProviderSoundcloud extends BaseProvider
{
    public function canPreview(): bool
    {
        return preg_match('/https:\/\/(?:www\.)?soundcloud\.com\/(.*\/.*)/i', $this->url) != false;
    }

    public function getPreview(): ?string
    {
        $url = sprintf('http://soundcloud.com/oembed?format=json&url=%s&iframe=true', urlencode($this->url));

        try {
            $content = json_decode(file_get_contents($url));
        } catch (\Exception $e) {
            unset($e);
            return null;
        }

        return str_replace(
            ['visual=true', 'show_artwork=true', 'height="400"'],
            ['visual=false', 'show_artwork=false', 'height="140"'],
            $content->html);
    }

}
