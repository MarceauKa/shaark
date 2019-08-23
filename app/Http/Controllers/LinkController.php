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
            'page_title' => 'Ajouter un lien',
            'submit' => route('api.link.store'),
            'parse' => route('api.link.parse'),
            'method' => 'POST',
            'query' => $request->query('url'),
            'tags' => Tag::all()->pluck('name')->toJson(),
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $link = Link::with('tags')->findOrFail($id);
        $link = \App\Http\Resources\Link::make($link)->toArray($request);

        return view('link-form')->with([
            'page_title' => 'Modifier un lien',
            'submit' => route('api.link.update', $id),
            'parse' => route('api.link.parse'),
            'method' => 'PUT',
            'link' => $link,
            'tags' => Tag::all()->pluck('name')->toJson(),
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

        $this->flash(sprintf('Le lien "%s" a été rafraîchit !', $link->title), 'success');
        return redirect()->back();
    }

    public function delete(Request $request, int $id, string $hash)
    {
        if ($hash !== csrf_token()) {
            abort(403);
        }

        /** @var Link $link */
        $link = Link::findOrFail($id);
        $link->delete();

        $this->flash(sprintf('Le lien "%s" a été supprimé !', $link->title), 'success');
        return redirect()->back();
    }
}
