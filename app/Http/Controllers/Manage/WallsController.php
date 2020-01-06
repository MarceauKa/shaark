<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

class WallsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('demo')->except('view');
    }

    public function view()
    {
        return view('manage.walls')->with([
            'page_title' => __('Walls'),
        ]);
    }
}
