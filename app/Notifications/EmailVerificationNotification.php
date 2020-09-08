<?php

namespace App\Notifications;

use App\EmailValidation;
use App\Mail\EmailVerificationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotification extends Notification
{
    use Queueable;

    /**
     * @var EmailValidation
     */
    private $validation;


    /**
     * Create a new notification instance.
     * @param EmailValidation $validation
     */
    public function __construct(EmailValidation $validation)
    {
        $this->validation = $validation;
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
     * @return EmailVerificationEmail
     */
    public function toMail($notifiable)
    {
        return (new EmailVerificationEmail($notifiable, $this->validation))->to($notifiable);
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
