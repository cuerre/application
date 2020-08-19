<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowCredits extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User model instance
     *
     * @var App\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  App\User  $user
     * @return void
     */
    public function __construct( User $user )
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notifications@cuerre.com') 
                    ->markdown('emails.lowcredits');
    }
}
