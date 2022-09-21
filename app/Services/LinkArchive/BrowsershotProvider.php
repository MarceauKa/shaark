<?php

namespace App\Services\LinkArchive;

use Spatie\Browsershot\Browsershot;

class BrowsershotProvider extends BaseProvider
{
    public function makeArchive(): ?string
    {
        $name = md5($this->url) . '.pdf';
        $filename = sprintf('app/archives/%s', $name);

        try {
            Browsershot::url($this->url)->width(app('shaark')->getArchivePdfWidth())
                ->setChromePath("/usr/bin/chromium-browser")
                ->height(app('shaark')->getArchivePdfHeight())
                ->showBackground()->margins(0,0,0,0)->fullPage()->savePdf($filename);
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
