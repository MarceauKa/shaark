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
        /** @var User $user */
        $user = User::isAdmin()->first();

       if ($notification === 'whitelist' && ! $comment->is_visible) {
            $user->notifyNow(new NewUnmoderatedComment($comment));
        }

        if ($notification === 'all' && $comment->user_id !== $user->id) {
            $user->notifyNow(new NewComment($comment));
        }
    }
}
