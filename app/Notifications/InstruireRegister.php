<?php

namespace App\Notifications;

use App\Mail\InstruireRegisterMail;
use App\PostRegister;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstruireRegister extends Notification
{
    use Queueable;

    /**
     * @var PostRegister
     */
    private PostRegister $postRegister;
    /**
     * @var Subscription|null
     */
    private ?Subscription $subscription;

    /**
     * Create a new notification instance.
     *
     * @param PostRegister $postRegister
     * @param Subscription|null $subscription
     */
    public function __construct(PostRegister  $postRegister, Subscription $subscription = null)
    {
        $this->postRegister = $postRegister;
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
     * @return InstruireRegisterMail
     */
    public function toMail($notifiable)
    {
        return (new InstruireRegisterMail($this->postRegister, $this->subscription))->to($notifiable);
    }
}
