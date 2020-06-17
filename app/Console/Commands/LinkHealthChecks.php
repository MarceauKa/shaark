<?php

namespace App\Console\Commands;

use App\Link;
use App\Services\Shaark\Shaark;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;

class LinkHealthChecks extends Command
{
    protected $signature = 'shaark:link_health_check {--all}';
    protected $description = 'Run health checks on links';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $check_all_links = $this->option('all');

        $links = Link::where('http_checked_at', '<', now()->subDays(app(Shaark::class)->getLinkHealthChecksAge()))
            ->orWhereNull('http_checked_at')
            ->orderBy('http_checked_at', 'ASC');

        if (! $check_all_links) {
            $links->limit(20);
        }

        $links->get()
            ->each(function (Link $link) {
                try {
                    $response = (new Client())->request('GET', $link->getUrlAttribute(), [
                        'headers' => [
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',
                        ],
                        'http_errors' => false,
                        'timeout' => 5,
                    ]);

                    $link->http_status = $response->getStatusCode();
                } catch (RequestException $exception) {
                    // Might happen when the domain as expired
                    $link->http_status = 500;
                } finally {
                    $link->http_checked_at = now();
                    $link->save();
                }
            });
    }
}
