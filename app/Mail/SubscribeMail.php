<?php

namespace App\Mail;

use App\Subscription;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;
    public $pdf;
    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Subscription $subscription
     */
    public function __construct(User $user, Subscription $subscription)
    {
        $this->user = $user;
        $this->pdf = PDF::loadView('invoices.subscription_pdf', compact('subscription')); #this works

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
            ->subject('Abonare Jurnal')
            ->attachData($this->pdf->output(), 'invoice_' . $this->subscription->created_at . '.pdf')
            ->markdown('emails.subscription');
    }
}
