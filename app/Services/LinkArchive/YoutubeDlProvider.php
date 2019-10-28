<?php

namespace App\Services\LinkArchive;

use YoutubeDl\Entity\Video;
use YoutubeDl\Exception\ExecutableNotFoundException;
use YoutubeDl\YoutubeDl;

class YoutubeDlProvider extends BaseProvider
{
    public function makeArchive(): ?string
    {
        $path = storage_path('app/archives');

        if (is_dir($path) === false) {
            mkdir($path);
        }

        try {
            $dl = new YoutubeDl([
                'format' => 'best',
                'restrict-filenames' => true,
                'max-downloads' => 1,
                'no-check-certificate' => true,
                'output' => md5($this->url) . '.%(ext)s',
            ]);

            $dl->setBinPath(app('shaarli')->getYoutubeDlBin());
            $dl->setDownloadPath($path);

            /*$dl->onProgress(function ($progress) {
                $percentage = $progress['percentage'];
                $size = $progress['size'];
                logger()->debug("Percentage: $percentage; Size: $size");
            });*/

            $result = $dl->download($this->url);

            if (false === $result instanceof Video) {
                return null;
            }

            logger()->debug('Link media archive', $result->toArray());
            return $result->getFilename();
        } catch (ExecutableNotFoundException $e) {
            throw new \RuntimeException("Unable to create link media archive", 0, $e);
        }
    }

    public function isEnabled(): bool
    {
        return app('shaarli')->getLinkArchiveMedia() === true;
    }

    public function canArchive(): bool
    {
        return true;
    }

    public static function test(string $url): bool
    {
        try {
            $dl = new YoutubeDl([
                'skip-download' => true,
                'restrict-filenames' => true,
                'max-downloads' => 1,
                'no-check-certificate' => true
            ]);

            $dl->setBinPath(app('shaarli')->getYoutubeDlBin());
            $dl->setDownloadPath(storage_path('app/archives'));
            $result = $dl->download($url);

            if (false === $result instanceof Video) {
                return false;
            }
        } catch (ExecutableNotFoundException $e) {
            unset($e);
            return false;
        }

        return true;
    }
}
