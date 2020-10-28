<?php

namespace App\Mail;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyExternalUsersAboutNewSeminarRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $data;
    /**
     * @var Post
     */
    public $post;

    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Inregistrarea la seminar')
            ->markdown('emails.seminar_register');
    }
}
