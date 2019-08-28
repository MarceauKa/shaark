<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLinkRequest;
use App\Link;
use App\Post;
use App\Services\WebParser;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function parse(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        $parser = WebParser::parse($request->get('url'));

        return response()->json([
            'title' => $parser->title,
            'content' => $parser->content,
        ]);
    }

    public function store(StoreLinkRequest $request)
    {
        $data = collect($request->validated());

        /** @var Link $link */
        $link = Link::create($data->only([
            'title',
            'content',
            'url',
        ])->toArray());

        $post = new Post();
        $post->is_private = $data->get('is_private', 0);
        $post->postable()->associate($link)->save();

        if ($data['tags']) {
            $post->syncTags($data['tags']);
        }

        if ($link->url) {
            $link->findExtra();
        }

        $post->save();

        return response()->json([
            'id' => $link->id,
            'status' => 'created',
        ]);
    }

    public function update(StoreLinkRequest $request, int $id)
    {
        $link = Link::findOrFail($id);
        $data = collect($request->validated());

        $link->fill($data->only('title', 'content', 'url')->toArray());
        $link->post->is_private = $data->get('is_private', $link->post->is_private);
        $link->post->save();

        if ($data['tags']) {
            $link->post->syncTags($data['tags']);
        }

        if ($link->url) {
            $link->findExtra();
        }

        $link->save();
        $link->post->save();

        return response()->json([
            'id' => $link->id,
            'status' => 'updated',
        ]);
    }
}
