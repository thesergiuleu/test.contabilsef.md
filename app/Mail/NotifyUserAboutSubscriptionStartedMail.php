<?php

namespace App\Mail;

use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserAboutSubscriptionStartedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Subscription
     */
    public  $subscription;

    /**
     * Create a new message instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Abonarea a inceput')
            ->markdown('emails.subscription_started');
    }
}
