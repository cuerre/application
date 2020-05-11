<?php

namespace App\Http\Controllers;

use Exception;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * CheckoutController instance
     * 
     * @var CheckoutController
     */
    private $checkout;

    /**
     * 
     * 
     */
    function __Construct(){

        # Generate Paypal instance (express checkout)
        $this->checkout = new CheckoutController();
    }

    /**
     * Recieves an amount of credits as input and 
     * goes to PayPal to finish transaction
     * 
     * @param   Request  $request
     * @return  RedirectResponse
     */
    public function Payment( Request $request )
    {
        try {

            # Validate the amount
            $validator = Validator::make($request->all(), [
                'credits'   => ['required','numeric']
            ]);

            # Go to billing
            if( $validator->fails() ){
                return redirect()
                            ->route('dashboard.billing')
                            ->withErrors($validator);
            }

            # Generate a random ID
            $invoideId = mt_rand(); //Str::random(20);

            $this->checkout->SetInvoice([
                'id'   => $invoideId, 
                'desc' => 'Order #'.$invoideId, 
            ])->SetItem([
                'name'  => 'Credits package', 
                'price' => $request->input('credits'), 
                'desc'  => 'Package of credits for using ' . config('app.name'), 
                'qty'   => 1
            ])->SetPayment();

        } catch ( Exception $e ) {

            Log::error( $e->getMessage() );

            # Go to billing page
            return redirect()
                        ->route('dashboard.billing')
                        ->with([
                            'message' => __('Imposible to go to payment page')
                        ]);
        }
    }

    /**
     * Just redirect the user with
     * a message 
     * 
     * @param
     * @return  RedirectResponse
     */
    public function Cancel()
    {
        try {
            return redirect()
                        ->route('dashboard.billing')
                        ->with([
                            'message' => __('Sorry, your payment was cancelled')
                        ]);
        } catch ( Exception $e ) {

            Log::error( $e->getMessage() );

            return redirect()
                        ->route('dashboard.billing')
                        ->with([
                            'message' => __('Imposible to go to payment page')
                        ]);
        }
    }

    /**
     * This is where to go when payment is done
     * to process and save it into our system
     * 
     * @param   Request $request
     * @return  RedirectResponse
     */
    public function Success(Request $request)
    {
        try {
            # Check token existance
            if( !$request->has('token') ){
                throw new Exception ('Success(): TOKEN field was not found in response');
            }

            # Get the transaction details
            $response = $this->checkout->GetPayment($request->token);

            # Convert response into a collection
            $response = collect($response);
    
            # Check if ACK field is present
            if( !$response->has('ACK') ){
                throw new Exception ('Success(): ACK field was not found in response');
            }

            # Check if payment failed
            $ack = strtoupper($response['ACK']);
            if ( !in_array($ack, ['SUCCESS', 'SUCCESSWITHWARNING']) ) {
                throw new Exception ('Success(): ACK field is not "success" or "successwithwarning"');
            }
    
            # Store the transaction into DB
            $payment          = new Payment;
            $payment->user_id = Auth::id();
            $payment->data    = $response->toArray();
            
            if( !$payment->save() ){
                throw new Exception ('Success(): Payment not saved into database');
            }

            # Sum the credits to the user
            Auth::user()->SumCredits($response['AMT']);

            # Go to billing index
            return redirect()
                        ->route('dashboard.billing')
                        ->with([
                            'message' => __('Thank you for your buy. Enjoy your credits')
                        ]);

        } catch ( Exception $e ){
            Log::error();

            # Go to billing index with errors
            return redirect()
                        ->route('dashboard.billing')
                        ->with([
                            'message' => __('Sorry, something was bad. If you have problems, contact support.')
                        ]);
        }
    }

}
