<?php

namespace App\Services;

class WebParser
{
    /** @var string $url */
    public $url;
    /** @var string $raw */
    public $raw;
    /** @var string $title */
    public $title;
    /** @var string $content */
    public $content;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function parse(string $url): self
    {
        return (new static($url))
            ->fetchContent()
            ->grepInfos();
    }

    public function fetchContent(): self
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, trim($this->url));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Accept: text/*; application/*',
            ]);
            $this->raw = curl_exec($curl);
            curl_close($curl);
        } catch (\Exception $e) {
            unset($e);
        }

        return $this;
    }

    public function grepInfos(): self
    {
        $this->grepTitle();
        $this->grepContent();

        return $this;
    }

    private function grepTitle(): string
    {
        if (preg_match('/<meta (?:name|property)=(?:"|\')og:title(?:"|\') content=(?:"|\')(.*)(?:"|\')(?:\s?\/?)>/', $this->raw, $matches)) {
            $this->title = strip_tags($matches[1]);
            return $this->title;
        }

        if (preg_match('/<title>(.*)<\/title>/', $this->raw, $matches)) {
            $this->title = strip_tags($matches[1]);
            return $this->title;
        }

        return '';
    }

    private function grepContent(): string
    {
        if (preg_match('/<meta name=(?:"|\')(?:og\:)?description(?:"|\') content=(?:"|\')(.*)(?:"|\')(?:\s?\/?)>/', $this->raw, $matches)) {
            $this->content = strip_tags($matches[1]);
            return $this->content;
        }

        return '';
    }
}
