<?php

namespace App\Console;

use App\Console\Commands\ResetForDemo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(ResetForDemo::class)
            ->when(function () {
                return config('shaarli.demo');
            })
            ->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
