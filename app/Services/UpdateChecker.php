<?php

namespace App\Services;

use App\Services\Shaark\Shaark;
use Illuminate\Support\Carbon;

class UpdateChecker
{
    const FEED_URL = 'https://github.com/MarceauKa/shaark/releases.atom';

    /** @var null|array $latest */
    public $latest = null;

    private function __construct()
    {
        try {
            $feed = simplexml_load_file(self::FEED_URL);
        } catch (\Exception $e) {
            unset($e);
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
