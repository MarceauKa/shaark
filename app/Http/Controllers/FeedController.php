<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Post;
use App\Services\Shaarli\Shaarli;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class FeedController extends Controller
{
    public function index(Request $request, Shaarli $shaarli, string $type)
    {
        if (false === in_array($type, ['rss', 'atom'])) {
            abort(404);
        }

        $items = Cache::rememberForever(sprintf('feed.%s', $type), function () use ($request) {
            return PostResource::collection(
                Post::withPrivate(false)
                ->with('postable')
                ->take(25)
                ->latest()
                ->get()
            )->toArray($request);
        });

        return view(sprintf('feed/%s', $type))->with([
            'title' => $shaarli->getName(),
            'link' => route('home'),
            'description' => __('All new content of :title', ['title' => $shaarli->getName()]),
            'language' => $shaarli->getLocale(),
            'pub_date' => count($items) ? $items[0]['created_at']->toRssString() : Carbon::now()->toRssString(),
            'items' => $items,
        ]);
    }
}
