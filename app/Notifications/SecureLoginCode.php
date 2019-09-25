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
                ->subject(__("Secure your login"))
                ->line(__("Please use the following code to access your account."))
                ->action($this->secure->code, sprintf('%s?code=%s', route('login.secure', $this->secure), $this->secure->code));
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
