<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        $tags = Tag::search($query)
                ->take(5)
                ->get();

        $posts = Post::search($query)
            ->query(function ($query) {
                return $query->with('tags', 'postable')
                            ->withPrivate(auth('api')->user());
            })
            ->take(10)
            ->get();

        return [
            'posts' => PostResource::collection($posts),
            'tags' => TagResource::collection($tags),
        ];
    }
}
