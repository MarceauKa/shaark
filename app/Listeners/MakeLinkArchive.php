<?php

namespace App\Listeners;

use App\Events\LinkArchiveRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeLinkArchive implements ShouldQueue
{
    public function handle(LinkArchiveRequested $event)
    {
        $event->link->createArchive();
    }
}
