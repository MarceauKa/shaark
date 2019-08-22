<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Link as LinkResource;
use App\Link;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        $links = Link::search($query)
            ->query(function ($query) {
                return $query->withPrivate(auth('api')->check());
            })
            ->take(5)
            ->get();

        return LinkResource::collection($links);
    }
}
