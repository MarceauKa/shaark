<?php

namespace App\Services;

use App\Services\Shaark\Shaark;

class HealthCheckStats
{
    /** @var \Illuminate\Support\Collection $stats */
    public $stats;

    public function __construct()
    {
        $this->stats = \DB::table('links')
            ->select('http_status', \DB::raw('count(id) as num_count'))
            ->groupBy('http_status')
            ->get();
    }

    public function get()
    {
        return [
            'num_healthy' => $this->countHealthy(),
            'num_other' => $this->countOther(),
            'num_dead' => $this->countDead(),
            'num_pending' => $this->countPending(),
        ];
    }

    public function isHealthCheckEnabled()
    {
        return app(Shaark::class)->getLinkHealthChecksEnabled();
    }

    public function countTotal()
    {
        return $this->stats->sum('num_count');
    }

    public function countHealthy()
    {
        return $this->stats->where('http_status', 200)->sum('num_count');
    }

    public function countOther()
    {
        $redirects = $this->stats->whereBetween('http_status', [300, 399])
            ->sum('num_count');

        $server_errors = $this->stats->whereBetween('http_status', [500, 599])
            ->sum('num_count');

        return $redirects + $server_errors;
    }

    public function countDead()
    {
        return $this->stats->whereBetween('http_status', [400, 499])
            ->sum('num_count');
    }

    public function countPending()
    {
        return \DB::table('links')
            ->where('http_checked_at', '<', now()->subDays(app(Shaark::class)->getLinkHealthChecksAge()))
            ->orWhereNull('http_checked_at')
            ->count();
    }

    public function countDisabled()
    {
        return \DB::table('links')
            ->where('is_health_check_enabled', 0)
            ->count();
    }
}
