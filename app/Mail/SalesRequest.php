<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalesRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The customer name
     *
     * @var string
     */
    public $name;



    /**
     * The customer email.
     *
     * @var string
     */
    public $email;



    /**
     * The customer message.
     *
     * @var string
     */
    public $message;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $email, string $message)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->message  = $message;
    }


    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@cuerre.com') 
                    ->markdown('emails.sales.request');
    }
}
