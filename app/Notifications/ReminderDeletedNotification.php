<?php

namespace App\Notifications;

use App\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The reminder that fired the notification.
     *
     * @var \App\Reminder $reminder
     */
    protected $reminder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->line("We are sending this email in order to inform that the notification 
                            {$this->reminder->name} created by @{$this->reminder->owner->username} was deleted.")
                    ->line('Thank you!');
    }
}
