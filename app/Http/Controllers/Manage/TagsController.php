<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('demo')->except('view');
    }

    public function view()
    {
        return view('manage.tags')->with([
            'page_title' => __('Tags'),
        ]);
    }
}
