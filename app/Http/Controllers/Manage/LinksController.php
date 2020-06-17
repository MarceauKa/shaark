<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Link;
use App\Services\HealthCheckStats;
use App\Services\Shaark\Shaark;

class LinksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('demo')->except('view');
    }

    public function view()
    {
        $stats = new HealthCheckStats();

        return view('manage.links')->with([
            'page_title' => __('Links'),
            'num_total' => $stats->countTotal(),
            'health_checks_enabled' => app(Shaark::class)->getLinkHealthChecksEnabled(),
            'num_pending' => $stats->countPending(),
            'num_healthy' => $stats->countHealthy(),
            'num_other' => $stats->countOther(),
            'num_dead' => $stats->countDead(),
        ]);
    }

    public function viewDead()
    {
        return view('manage.links_dead')->with([
            'page_title' => __('Dead Links'),
            'dead_links' => Link::whereBetween('http_status', [400, 499])->orderBy('http_checked_at', 'DESC')->paginate(10),
        ]);
    }

    public function viewOther()
    {
        return view('manage.links_other')->with([
            'page_title' => __('Other Status Links'),
            'other_links' => Link::whereBetween('http_status', [300, 399])
                ->orWhereBetween('http_status', [500, 599])
                ->orderBy('http_checked_at', 'DESC')->paginate(10),
        ]);
    }
}
