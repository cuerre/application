<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowCredits;

/** 
 * NotificationController is who sends the emails to the users
 * 
 * NotificationController is a Controller that wraps the actions
 * to send a mailable from the application to the users.
 * 
 * Example usage:
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class NotificationController extends Controller
{
    /**
     * User data
     * 
     * @var App\User
     */
    private $user;

    /**
     * 
     * @param  App\User  $user
     * @return void
     */
    function __Construct( User $user )
    {
        # Save user data into attributes
        $this->user = $user;
    }

    /**
     * Send a notification to the user 
     * saying "you have low credits bro"
     * 
     * @return void
     */
    public function NotifyLowCredits ()
    {
        try {

            # Notify to buy more
            Mail::to( $this->user->email )
                ->send(new LowCredits( $this->user ) );

        } catch ( Exception $e ){
            Log::error( $e->getMessage() );
        }
    }


}
