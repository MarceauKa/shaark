<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanFiles extends Command
{
    protected $signature = 'shaark:clean-files';
    protected $description = 'Remove temporary uploaded files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dirs = [
            ['path' => 'tmp/', 'search' => '/^(.*)$/', 'disk' => 'local'],
            ['path' => '/', 'search' => '/\.part$/', 'disk' => 'archives'],
        ];

        foreach ($dirs as $dir) {
            $this->cleanDirectory($dir);
        }
    }

    protected function cleanDirectory(array $options): void
    {
        ['path' => $path, 'search' => $search, 'disk' => $disk] = $options;
        $files = Storage::disk($disk)->files($path);

        if ($this->option('verbose')) $this->info("Disk $disk:");

        foreach ($files as $file) {
            $name = basename($file);

            if (preg_match('/^\./', $name)) {
                if ($this->option('verbose')) $this->comment("Ignore $name");

                continue;
            }

            if (preg_match($search, $name)) {
                if ($this->option('verbose')) $this->comment("Delete $name");

                Storage::disk($disk)->delete($file);

                continue;
            }

            if ($this->option('verbose')) $this->comment("Keep $name");
        }
    }
}
