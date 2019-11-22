<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUnmoderatedComment extends Notification
{
    use Queueable;

    /** @var Comment $comment */
    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject(__('shaark.mails.unmoderated.title'))
                ->line(__('shaark.mails.unmoderated.message', [
                    'name' => $this->comment->user->name,
                    'email' => $this->comment->user->email,
                    'post' => $this->comment->post->postable->title,
                ]))
                ->action(__('shaark.mails.unmoderated.action'), $this->comment->post->postable->permalink);
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
