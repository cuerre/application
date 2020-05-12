<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Mail to send support requests
     */
    private $to;

    /**
     * Constructor, asign values
     * 
     * @return void
     */
    function __Construct()
    {
        $this->to = 'support@cuerre.com';
    }

    /**
     * Check and queue the message of a customer
     * asking for support from the dashboard
     * form
     * 
     * @param  Illuminate\Http\Request
     * @return Redirect
     */
    public function SendRequest(Request $request)
    {
        try {

            # Check if message is right
            $validator = Validator::make($request->all(), [
                'text' => [
                    'required',
                    'string',
                    'max:1000'
                ],
            ]);

            if( $validator->fails() ){

                return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
            }

            # Validator passes, send an email to the team
            # and a copy to the user
            Mail::to($this->to)
                //->cc(Auth::user()->email)
                ->send(new SupportRequest( 
                    Auth::user(), 
                    $request->input('text') 
                ));

            # Message sent
            return redirect()
                    ->back()
                    ->with([
                        'message' => __('Your message is being sent and will be answered as soon as possible')
                    ]);

        } catch ( Exception $e ) {
            Log::error($e->getMessage());

            return redirect()
                    ->back()
                    ->with([
                        'message' => __('Impossible to send the message. Please, try again later.')
                    ]);

        }
    }
}
