<?php

namespace App\Http\Controllers;

use App\Chest;
use App\Link;
use App\Post;
use App\Services\Shaarli\Shaarli;
use App\Story;
use App\Tag;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index(Request $request, Shaarli $shaarli)
    {
        $tags = collect([]);
        $posts = Post::with('tags', 'postable');

        if (false === $shaarli->getHomeShowChests()) {
            $posts->withoutChests();
        }

        $posts = $posts->withPrivate($request)
            ->latest()
            ->paginate(20);

        if (true === $shaarli->getHomeShowTags()) {
            $tags = Tag::withCount('posts')
                ->orderBy('posts_count', 'desc')
                ->get();
        }

        return view('home')->with([
            'page_title' => app('shaarli')->getName(),
            'posts' => $posts,
            'tags' => $tags,
            'compact' => $shaarli->getCompactCardslist(),
            'columns_count' => $shaarli->getColumnsCount(),
        ]);
    }

    public function link(Request $request, string $hash)
    {
        $link = Link::withPrivate($request)
                ->with('post.tags')
                ->hashIdIs($hash)
                ->firstOrFail();

        return view('link')->with([
            'page_title' => sprintf('%s - #%s', $link->title, $link->hash_id),
            'link' => $link,
            'post' => $link->post,
        ]);
    }

    public function story(Request $request, string $slug)
    {
        $story = Story::withPrivate($request)
            ->with('post.tags')
            ->slugIs($slug)
            ->firstOrFail();

        return view('story')->with([
            'page_title' => sprintf('%s', $story->title),
            'story' => $story,
            'post' => $story->post,
        ]);
    }

    public function chest(Request $request, string $hash)
    {
        $chest = Chest::withPrivate($request)
            ->with('post.tags')
            ->hashIdIs($hash)
            ->firstOrFail();

        return view('chest')->with([
            'page_title' => sprintf('%s - #%s', $chest->title, $chest->hash_id),
            'chest' => $chest,
            'post' => $chest->post,
        ]);
    }

    public function tag(Request $request, Shaarli $shaarli, string $tag)
    {
        $tag = Tag::named($tag)->firstOrFail();

        $posts = Post::withPrivate($request)
                ->with('postable', 'tags')
                ->withAllTags($tag)
                ->paginate(20);

        abort_if($posts->isEmpty(), 404);

        return view('tag')->with([
            'page_title' => vsprintf('%s %s - %s n°%d', [
                __('Tagged'),
                $tag->name,
                __('Page'),
                $request->input('page', 1),
            ]),
            'tag' => $tag,
            'posts' => $posts,
            'compact' => $shaarli->getCompactCardslist(),
            'columns_count' => $shaarli->getColumnsCount(),
        ]);
    }
}
