<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        return view('link-form')->with([
            'submit' => route('api.link.store'),
            'parse' => route('api.link.parse'),
            'method' => 'POST',
            'query' => $request->query('url'),
            'link' => new Link,
            'tags' => Tag::all()->pluck('name')->toJson(),
        ]);
    }
}
