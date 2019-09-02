<?php

namespace App\Services\LinkContent;

use Nesk\Puphpeteer\Puppeteer;

class FallbackProvider extends BaseProvider
{
    public function makeArchive(): ?string
    {
        $name = md5($this->url) . '.pdf';
        $filename = sprintf('app/archives/%s', $name);

        try {
            $puppeteer = new Puppeteer();
            $browser = $puppeteer->launch([
                'ignoreHTTPSErrors' => true,
            ]);

            $page = $browser->newPage();
            $page->goto($this->url);
            $page->emulateMedia('screen');

            $page->pdf([
                'path' => storage_path($filename),
                'width' => 1440,
                'height' => 960,
                'printBackground' => true,
                'preferCSSPageSize' => true,
                'margin' => [
                    'top' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'right' => 0,
                ]
            ]);

            $browser->close();
        } catch (\Exception $e) {
            throw new \RuntimeException("Unable to create link archive", 0, $e);
        }

        return $name;
    }

    public function canArchive(): bool
    {
        return true;
    }

    public function canPreview(): bool
    {
        return false;
    }

    public function getPreview(): ?string
    {
        return null;
    }
}
