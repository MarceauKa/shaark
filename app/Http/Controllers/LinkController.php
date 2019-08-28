<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        return view('form-link')->with([
            'page_title' => __('Add link'),
            'submit' => route('api.link.store'),
            'parse' => route('api.link.parse'),
            'method' => 'POST',
            'query' => $request->query('url')
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $link = Link::with('post.tags')->findOrFail($id);

        return view('form-link')->with([
            'page_title' => __('Update link'),
            'submit' => route('api.link.update', $id),
            'parse' => route('api.link.parse'),
            'method' => 'PUT',
            'link' => $link,
        ]);
    }

    public function refresh(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Link $link */
        $link = Link::findOrFail($id);
        $link->findExtra();

        $this->flash(__('Link :name has been refreshed', ['name' => $link->title]), 'success');
        return redirect()->back();
    }

    public function delete(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Link $link */
        $link = Link::with('post')->findOrFail($id);

        $link->delete();
        $link->post->delete();

        $this->flash(__('Link :name has been deleted', ['name' => $link->title]), 'success');
        return redirect()->back();
    }
}
