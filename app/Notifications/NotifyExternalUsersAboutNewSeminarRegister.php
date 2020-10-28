<?php

namespace App\Notifications;

use App\Mail\NotifyExternalUsersAboutNewSeminarRegisterMail;
use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyExternalUsersAboutNewSeminarRegister extends Notification
{
    use Queueable;

    /**
     * @var array
     */
    private $data;
    /**
     * @var Post
     */
    private $post;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     * @param Post $post
     */
    public function __construct(array $data, Post $post)
    {
        $this->data = $data;
        $this->post = $post;
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
     * @return NotifyExternalUsersAboutNewSeminarRegisterMail
     */
    public function toMail($notifiable)
    {
        return (new NotifyExternalUsersAboutNewSeminarRegisterMail($this->data, $this->post))->to($notifiable->email);
    }
}
