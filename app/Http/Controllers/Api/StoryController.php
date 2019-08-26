<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoryRequest;
use App\Post;
use App\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(StoreStoryRequest $request)
    {
        $data = collect($request->validated());

        /** @var Story $link */
        $story = Story::create($data->only([
            'title',
            'slug',
            'content',
        ])->toArray());

        $post = new Post();
        $post->is_private = $data->get('is_private', 0);
        $post->postable()->associate($story)->save();

        if ($data['tags']) {
            $post->syncTags($data['tags']);
        }

        return response()->json([
            'id' => $story->id,
            'status' => 'created',
        ]);
    }

    public function update(StoreStoryRequest $request, int $id)
    {
        $story = Story::with('post.tags')->findOrFail($id);
        $data = collect($request->validated());

        $story->fill($data->only('title', 'slug', 'content')->toArray());
        $story->post->is_private = $data->get('is_private', $story->post->is_private);
        $story->post->save();

        if ($data['tags']) {
            $story->post->syncTags($data['tags']);
        }

        $story->save();

        return response()->json([
            'id' => $story->id,
            'status' => 'updated',
        ]);
    }
}
