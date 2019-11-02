<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

class ArchivesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'demo']);
    }

    public function view()
    {
        return view('manage.archives')->with([
            'page_title' => __('Archives'),
        ]);
    }
}
