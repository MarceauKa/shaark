<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\CommentResource;
use App\Post;
use App\Services\Shaark\Shaark;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['auth:api']);
    }

    public function get(Request $request, int $id)
    {
        $post = Post::withPrivate($request)
            ->findOrFail($id);

        $comments = Comment::postIs($id)
            ->withVisible($request)
            ->get();

        return response()->json([
            'comments' => CommentResource::collection($comments),
        ]);
    }

    public function store(AddCommentRequest $request, Shaark $shaark, int $id)
    {
        $data = $request->validated();
        $user = $request->user('api');

        $comment = new Comment([
            'content' => $data['content'],
            'comment_id' => $data['reply'],
            'post_id' => $id,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? null : $data['name'],
            'user_email' => $user ? null : $data['email'],
        ]);

        if ($user) {
            $comment->is_visible = true;
        } else {
            switch ($shaark->getCommentsModeration()) {
                case 'all':
                case 'whitelist':
                    $whitelisted = Comment::where('user_email', $data['email'])
                        ->isVisible()
                        ->count();
                    $comment->is_visible = $whitelisted > 0;
                    break;
                case 'disabled':
                default:
                    $comment->is_visible = true;
                    break;
            }
        }

        $comment->save();

        return response()->json([
            'comment' => new CommentResource($comment),
            'message' => $comment->is_visible ? __('Saved') : __('You comment will be displayed once moderated'),
            'status' => 'created',
        ]);
    }
}
