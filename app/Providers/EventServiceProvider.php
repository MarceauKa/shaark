<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\LinkArchiveRequested::class => [
            \App\Listeners\MakeLinkArchive::class
        ],
        \Illuminate\Database\Events\MigrationEnded::class => [
            \App\Listeners\UpdateDatabase::class
        ],
    ];

    public function boot()
    {
        parent::boot();

        \App\Comment::observe(\App\Observers\CommentObserver::class);
        \App\Tag::observe(\App\Observers\TagObserver::class);
        \App\Wall::observe(\App\Observers\WallObserver::class);
    }
}
