<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Http\Resources\TagResource;
use App\Link;
use App\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        $tags = Tag::search($query)
                ->query(function ($query) {
                    return $query->withCount('links');
                })
                ->take(3)
                ->get();

        $links = Link::search($query)
            ->query(function ($query) {
                return $query->withPrivate(auth('api')->check());
            })
            ->take(3)
            ->get();

        return [
            'links' => LinkResource::collection($links),
            'tags' => TagResource::collection($tags),
        ];
    }
}
