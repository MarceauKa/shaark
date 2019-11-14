<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckEmail extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject(__('shaark.mails.check.title'))
                ->line(__('shaark.mails.check.message', ['name' => config('app.name')]));
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
