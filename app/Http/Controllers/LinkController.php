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

    public function edit(Request $request, int $id)
    {
        $link = Link::with('tags')->findOrFail($id);
        $link = \App\Http\Resources\Link::make($link)->toArray($request);

        return view('link-form')->with([
            'submit' => route('api.link.update', $id),
            'parse' => route('api.link.parse'),
            'method' => 'PUT',
            'link' => $link,
            'tags' => Tag::all()->pluck('name')->toJson(),
        ]);
    }

    public function delete(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        $link = Link::findOrFail($id);
        $link->delete();

        return redirect()->back();
    }
}
