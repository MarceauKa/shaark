<?php

namespace App\Listeners;

use App\Events\LinkArchiveRequested;
use App\Services\LinkArchive\LinkArchive;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class MakeLinkArchive implements ShouldQueue
{
    public function handle(LinkArchiveRequested $event)
    {
        logger()->info(sprintf('Archiving link %d with %s driver.', $event->link->id, $event->provider));

        $link = $event->link;
        $file = LinkArchive::archive($link->url, $event->provider);

        if (Storage::disk('archives')->exists($file)) {
            $link->archive = $file;
            $link->save();
        }
    }
}
