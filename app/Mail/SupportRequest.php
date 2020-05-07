<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The user name.
     *
     * @var Authenticator
     */
    public $user;

    /**
     * The user email.
     *
     * @var String
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, string $content)
    {
        $this->user    = $user;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@cuerre.com') 
                    ->markdown('emails.support.request');
    }
}
