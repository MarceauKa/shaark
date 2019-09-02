<?php

namespace App\Services\LinkArchive;

abstract class BaseProvider
{
    /** @var string $url */
    public $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    abstract public function isEnabled(): bool;

    abstract public function canArchive(): bool;

    abstract public function makeArchive(): ?string;
}
