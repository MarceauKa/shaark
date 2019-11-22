<?php

namespace App\Observers;

use App\Comment;
use App\Notifications\NewComment;
use App\Notifications\NewUnmoderatedComment;
use App\User;

class CommentObserver
{
    public function created(Comment $comment)
    {
        $notification = app('shaark')->getCommentsNotification();
        $users = User::isAdmin()->get();

        $users->each(function (User $user) use ($notification, $comment) {
            if ($comment->user_id === $user->id) {
                return;
            }

            if ($notification !== 'disabled' && false == $comment->is_visible) {
                $user->notifyNow(new NewUnmoderatedComment($comment));
            } else if ($notification === 'all' && $comment->is_visible) {
                $user->notifyNow(new NewComment($comment));
            }
        });
    }
}
