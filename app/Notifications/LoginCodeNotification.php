<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $code,
        public string $expiresInMinutes = '10'
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('messages.login_code_email_subject_with_code', ['code' => $this->code]))
            ->greeting(__('messages.hello_name', ['name' => $notifiable->name]))
            ->line(__('messages.login_code_email_intro'))
            ->line(__('messages.your_login_code_is'))
            ->line('**' . $this->code . '**')
            ->line(__('messages.login_code_expires', ['minutes' => $this->expiresInMinutes]))
            ->line(__('messages.login_code_security_notice'))
            ->line(__('messages.thank_you'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
