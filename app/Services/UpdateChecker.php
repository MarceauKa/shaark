<?php

namespace App\Services;

use App\Services\Shaark\Shaark;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class UpdateChecker
{
    const FEED_URL = 'https://github.com/MarceauKa/shaark/releases.atom';

    /** @var null|array $latest */
    public $latest = null;

    private function __construct()
    {
        $body = null;

        try {
            $response = (new Client())->request('GET', self::FEED_URL, [
                'headers'     => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36',
                ],
                'http_errors' => false,
                'timeout'     => 5,
            ]);

            $body = $response->getBody()->getContents();
        } catch (\Exception $e) {
            unset($e);
            return;
        }

        try {
            $feed = simplexml_load_string($body);
        } catch (\Exception $e) {
            unset($e);
            return;
        }

        if ($feed instanceof \SimpleXMLElement) {
            $entry = (array)$feed->entry[0];

            $this->latest = [
                'id' => (string)$entry['title'],
                'changelog' => (string)$entry['content'],
                'link' => (string)$entry['link']->attributes()->href,
                'date' => Carbon::createFromFormat(DATE_ATOM, $entry['updated']),
                'is_new' => version_compare($entry['title'], Shaark::VERSION) >= 1,
            ];
        }
    }

    public static function check(): self
    {
        return new static();
    }
}
