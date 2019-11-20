<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth:api']);
    }

    public function get(Request $request, int $id)
    {
        $post = Post::withPrivate($request)->findOrFail($id);
        $comments = Comment::postIs($id)->get();

        return response()->json([
            'comments' => CommentResource::collection($comments),
        ]);
    }
}
