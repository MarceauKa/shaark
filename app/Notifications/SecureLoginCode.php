<?php

namespace App\Notifications;

use App\SecureLogin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecureLoginCode extends Notification
{
    use Queueable;

    /** @var SecureLogin $secure */
    public $secure;

    public function __construct(SecureLogin $secure)
    {
        $this->secure = $secure;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject(__('shaarli.mails.2fa.title'))
                ->line(__('shaarli.mails.2fa.message', ['code' => $this->secure->code]))
                ->action(__('shaarli.mails.2fa.button'), sprintf('%s?code=%s', route('login.secure', $this->secure), $this->secure->code));
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
