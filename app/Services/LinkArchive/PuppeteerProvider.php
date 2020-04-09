<?php

namespace App\Services\LinkArchive;

use Nesk\Puphpeteer\Puppeteer;

class PuppeteerProvider extends BaseProvider
{
    public function makeArchive(): ?string
    {
        $name = md5($this->url) . '.pdf';
        $filename = sprintf('app/archives/%s', $name);

        try {
            $puppeteer = new Puppeteer([
                'executable_path' => app('shaark')->getNodeBin()
            ]);

            $browser = $puppeteer->launch([
                'ignoreHTTPSErrors' => true,
            ]);

            $page = $browser->newPage();
            $page->goto($this->url);
            $page->emulateMedia('screen');

            $page->pdf([
                'path' => storage_path($filename),
                'width' => app('shaark')->getArchivePdfWidth(),
                'height' => app('shaark')->getArchivePdfHeight(),
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
            throw new \RuntimeException("Unable to create link pdf archive", 0, $e);
        }

        return $name;
    }

    public function isEnabled(): bool
    {
        return app('shaark')->getLinkArchivePdf() === true;
    }

    public function canArchive(): bool
    {
        return true;
    }
}
