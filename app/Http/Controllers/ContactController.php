<?php

namespace App\Http\Controllers;

use Exception;
use App\Exceptions\ContactException;
use App\Mail\SupportRequest;
use App\Mail\SalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Mail to send support requests
     * 
     * @var array
     */
    private $to;



    /**
     * Recaptcha API keys
     * 
     * @var array
     */
    private $recaptcha;



    /**
     * Constructor, asign values
     * 
     * @return void
     */
    function __Construct()
    {
        $this->to['sales']   = 'sales@cuerre.com';
        $this->to['support'] = 'support@cuerre.com';

        $this->recaptcha['secret'] = config('recaptcha.secret');
        $this->recaptcha['public'] = config('recaptcha.public');
    }



    /**
     * Check and queue the message of a customer
     * asking for sales
     * 
     * @param  Illuminate\Http\Request
     * @return Redirect
     */
    public function SendSalesRequest(Request $request)
    {
        try {

            # Check if fields are right
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string','max:100'],
                'email' => ['required','string','max:100', 'email:rfc'],
                'message' => ['required','string','max:1000'],
                'g-recaptcha-response' => ['required','string'],
            ]);

            if( $validator->fails() ){
                throw new ContactException ('Some field is malformed');
            }

            # Check Re-Captcha 
            if( !$this->CheckRecaptchaToken ($request->input('g-recaptcha-response')) ){
                throw new ContactException ('Re-Captcha failed. Try again in some minutes.');
            }

            # Send an email to the team
            Mail::to($this->to['sales'])
                ->send(new SalesRequest( 
                    $request->input('name'), 
                    $request->input('email'),
                    $request->input('message') 
                ));

            # Message sent
            return redirect()
                 ->back()
                 ->with([
                       'message' => __('Your message is being sent and will be answered as soon as possible')
                   ]);

        } catch ( ContactException $e ) {
            Log::error($e);

            return redirect()
                 ->back()
                 ->withErrors([
                       'message' => __($e->getMessage())
                   ]);

        }
    }



    /**
     * Check and queue the message of a customer
     * asking for support from the dashboard
     * form
     * 
     * @param  Illuminate\Http\Request
     * @return Redirect
     */
    public function SendSupportRequest(Request $request)
    {
        try {

            # Check if message is right
            $validator = Validator::make($request->all(), [
                'text' => ['required','string','max:1000'],
            ]);

            if( $validator->fails() ){
                throw new ContactException ('Some field is malformed');
            }

            # Validator passes, send an email to the team
            # and a copy to the user
            Mail::to($this->to['support'])
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

        } catch ( ContactException $e ) {
            Log::error($e);

            return redirect()
                 ->back()
                 ->withErrors([
                       'message' => __($e->getMessage())
                   ]);

        }
    }



    /**
     * Check if a token is valid in 
     * RE-Captcha service
     * 
     * @return bool
     */
    public function CheckRecaptchaToken ( string $token )
    {
        try{
            $url = "https://www.google.com/recaptcha/api/siteverify";
            $data = array(
                "secret"   => $this->recaptcha['secret'], 
                "response" => $token, 
            );
            $data = http_build_query($data);

            // use key "http" even if you send the request to https://...
            $options = array(
                "http" => array(
                    "method"  => "POST",
                    "header"  => "Content-type: application/x-www-form-urlencoded\r\n"
                                ."Content-Length: " . strlen($data) . "\r\n",
                    "content" => $data,
                ),
            );
            $context  = stream_context_create($options);
            $result   = file_get_contents($url, false, $context);

            if( is_null(json_decode($result, true)) ){
                return false;
            }

            return true;
        } catch ( Exception $e ){

            Log::error($e);
            return false;
        }
    }
}
