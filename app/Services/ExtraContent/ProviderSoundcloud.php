<?php

namespace App\Services\ExtraContent;

class ProviderSoundcloud extends BaseProvider
{
    public function check(): bool
    {
        return preg_match('/https:\/\/(?:www\.)?soundcloud\.com\/(.*\/.*)/i', $this->url) != false;
    }

    public function get(): ?string
    {
        $url = sprintf('http://soundcloud.com/oembed?format=json&url=%s&iframe=true', urlencode($this->url));

        try {
            $content = json_decode(file_get_contents($url));
        } catch (\Exception $e) {
            unset($e);
            return null;
        }

        return $content->html;
    }

}
