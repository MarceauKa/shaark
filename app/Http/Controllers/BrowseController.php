<?php

namespace App\Http\Controllers;

use App\Chest;
use App\Link;
use App\Post;
use App\Story;
use App\Tag;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('tags', 'postable')
            ->withPrivate($request)
            ->latest()
            ->paginate(20);

        return view('home')->with([
            'page_title' => config('app.name'),
            'posts' => $posts,
            'lang' => "{lang:fr}",
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

    public function tag(Request $request, string $tag)
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
        ]);
    }
}
