<?php

namespace App\Mail;

use App\Subscription;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Subscription
     */
    public $subscription;

    /**
     * Create a new message instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->pdf = PDF::loadView('invoices.subscription_pdf', compact('subscription')); #this works
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Abonare Jurnal')
            ->attachData($this->pdf->output(), 'invoice_' . $this->subscription->created_at . '.pdf')
            ->markdown('emails.subscription_reminder');
    }
}
