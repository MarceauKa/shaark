<?php

namespace App\Console;

use App\Console\Commands\CleanFiles;
use App\Console\Commands\ResetForDemo;
use App\Services\Shaarli\Shaarli;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }

    protected function schedule(Schedule $schedule)
    {
        // Reset Demo
        $schedule->command(ResetForDemo::class)
            ->when(function () {
                return config('shaarli.demo');
            })
            ->hourly();

        // Clean files
        $schedule->command(CleanFiles::class)
            ->hourly();

        // Make backup
        $this->scheduleBackup($schedule);
    }

    protected function scheduleBackup(Schedule $schedule): self
    {
        $shaarli = app(Shaarli::class);

        if (false === $shaarli->getBackupEnabled()) {
            return $this;
        }

        $params = $shaarli->getBackupOnlyDatabase() ? ['--only-db'] : [];

        if ($shaarli->getBackupPeriod() === 'daily') {
            $schedule->command('backup:clean')->daily()->at('01:00');
            $schedule->command('backup:run', $params)->daily()->at('02:00');
        }

        if ($shaarli->getBackupPeriod() === 'weekly') {
            $schedule->command('backup:clean')->weekly()->at('01:00');
            $schedule->command('backup:run', $params)->weekly()->at('02:00');
        }

        return $this;
    }
}
