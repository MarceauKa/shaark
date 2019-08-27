<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChestRequest;
use App\Chest;
use App\Post;
use Illuminate\Http\Request;

class ChestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(StoreChestRequest $request)
    {
        $data = collect($request->validated());

        /** @var Chest $link */
        $chest = Chest::create($data->only([
            'title',
            'content',
        ])->toArray());

        $post = new Post(['is_private' => true]);
        $post->postable()->associate($chest)->save();

        if ($data['tags']) {
            $post->syncTags($data['tags']);
        }

        return response()->json([
            'id' => $chest->id,
            'status' => 'created',
        ]);
    }

    public function update(StoreChestRequest $request, int $id)
    {
        $chest = Chest::findOrFail($id);
        $data = collect($request->validated());

        $chest->fill($data->only('title', 'content')->toArray());

        if ($data['tags']) {
            $chest->post->syncTags($data['tags']);
        }

        $chest->save();

        return response()->json([
            'id' => $chest->id,
            'status' => 'updated',
        ]);
    }
}
