<?php

namespace App\Mail;

use App\EmailValidation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public User $user;
    /**
     * @var EmailValidation
     */
    public EmailValidation $validation;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param EmailValidation $validation
     */
    public function __construct(User $user, EmailValidation $validation)
    {
        $this->user = $user;
        $this->validation = $validation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Cont nou ContabilSef')
            ->markdown('emails.register_confirmation');
    }
}
