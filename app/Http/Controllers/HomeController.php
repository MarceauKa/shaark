<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $links = Link::latest()
            ->withPrivate(auth()->check())
            ->with('tags')
            ->paginate(25);

        return view('home')->with([
            'links' => $links,
        ]);
    }
}
