<?php

namespace App\Mail;

use App\PostRegister;
use App\Subscription;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstruireRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var PostRegister
     */
    public PostRegister $postRegister;
    /**
     * @var Subscription|null
     */
    public ?Subscription $subscription;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @param PostRegister $postRegister
     * @param Subscription|null $subscription
     */
    public function __construct(PostRegister $postRegister, Subscription $subscription = null)
    {
        $this->postRegister = $postRegister;
        $this->subscription = $subscription;

        $price = $postRegister->post->price;
        if ($subscription) {
            $discount = setting('site.instruire_register_discount', 10);
            $price = apply_discount($price, $discount);

            if ($subscription->message == 'Mesaj din sistem: Abonatul este creat in urma inregistrarii la seminar-ul ' . $postRegister->post->title && !$subscription->payed_at) {
                #pdf for subscription and register with discount
                $this->pdf = PDF::loadView('invoices.register_pdf', compact('postRegister', 'subscription', 'price')); #this works
            } else {
                #pdf for register only with discount
                $this->pdf = PDF::loadView('invoices.register_pdf', compact('postRegister', 'price')); #this works
            }
        } else {
            #pdf for register only without discount
            $this->pdf = PDF::loadView('invoices.register_pdf', compact('postRegister', 'price')); #this works
        }


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Inregistrare seminar')
            ->attachData($this->pdf->output(), 'invoice_' . $this->postRegister->created_at . '.pdf')
            ->markdown('emails.seminar_register');
    }
}
