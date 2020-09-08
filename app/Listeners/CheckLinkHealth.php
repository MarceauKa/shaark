<?php

namespace App\Listeners;

use App\Events\LinkHealthCheck;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckLinkHealth implements ShouldQueue
{
    public function handle(LinkHealthCheck $event)
    {
        logger()->info(sprintf('Checking link health %d.', $event->link->id));

        $link = $event->link;

        try {
            $response = (new Client())->request('GET', $link->url, [
                'headers'     => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',
                ],
                'http_errors' => false,
                'verify'      => false,
                'timeout'     => 5,
            ]);

            $link->http_status = $response->getStatusCode();
        } catch (RequestException $exception) {
            // Might happen when the domain has expired
            $link->http_status = 500;
        } finally {
            $link->http_checked_at = now();
            $link->save();
        }
    }
}
