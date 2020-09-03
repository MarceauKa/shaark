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
        return view('manage.links')->with([
            'page_title' => __('Links'),
            'stats' => new HealthCheckStats(),
        ]);
    }

    public function viewDead()
    {
        return view('manage.links_dead')->with([
            'page_title' => __('Dead Links'),
            'stats' => new HealthCheckStats(),
            'dead_links' => Link::whereBetween('http_status', [400, 499])->orderBy('http_checked_at', 'DESC')->paginate(10),
        ]);
    }

    public function viewOther()
    {
        return view('manage.links_other')->with([
            'page_title' => __('Other Status Links'),
            'stats' => new HealthCheckStats(),
            'other_links' => Link::whereBetween('http_status', [300, 399])
                ->orWhereBetween('http_status', [500, 599])
                ->orderBy('http_checked_at', 'DESC')->paginate(10),
        ]);
    }

    public function viewDisabled()
    {
        return view('manage.links_disabled')->with([
            'page_title' => __('Disabled Links'),
            'stats' => new HealthCheckStats(),
            'disabled_links' => Link::where('is_health_check_enabled', 0)->paginate(10),
        ]);
    }
}
