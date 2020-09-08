<?php

namespace App\Notifications;

use App\Mail\SubscriptionReminderMail;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendSubscriptionReminderNotification extends Notification
{
    use Queueable;

    /**
     * @var Subscription
     */
    private  $subscription;

    /**
     * Create a new notification instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
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
     * @return SubscriptionReminderMail
     */
    public function toMail($notifiable)
    {
        return (new SubscriptionReminderMail($this->subscription))->to($notifiable);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
