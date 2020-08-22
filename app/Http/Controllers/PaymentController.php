<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Exceptions\PaymentException;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
     * Create a new payment 
     * or try to retrieve the url's one
     * if present
     * 
     * @param Illuminate\Http\Request $request
     */
    function __Construct( Request $request )
    {
        # Generate Paypal instance (checkout)
        if ( $request->has('paymentHash') ){
            $this->checkout = new CheckoutController(
                $request->input('paymentHash')
            );
        }else{
            $this->checkout = new CheckoutController();
        }
    }



    /**
     * Recieves an amount of credits as input and 
     * goes to Paypal to finish payment
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
                     ->route('desk.billing')
                     ->withErrors($validator);
            }

            # Go to do the payment
            $this->checkout
                 ->SetTotal( $request->input('credits') )
                 ->SetPayment();

        } catch ( PaymentException $e ) {

            Log::error( $e );

            # Go to billing page
            return redirect()
                 ->route('desk.billing')
                 ->with([
                     'message' => __('Imposible to go to payment page')
                 ]);
        }
    }



    /**
     * This is where to go when payment is returned
     * 
     * @param   Request $request
     * @return  RedirectResponse
     */
    public function Return( Request $request )
    {
        try {

            # Get payment details
            $payment = $this->checkout->GetPayment();

            # Check if we have details
            if ( empty($payment['outcome']) ){
                throw new PaymentException ('could not get the payment outcome');
            }

            # Check if we have status on the outcome
            if ( empty($payment['outcome']['result']['status']) ){
                throw new PaymentException ('could not get the payment status');
            }

            # Check if outcome status is 'COMPLETED'
            if ( $payment['outcome']['result']['status'] != 'COMPLETED' ){
                throw new PaymentException ('payment outcome status is not COMPLETED');
            }
    
            # Store the transaction into DB
            $newPayment           = new Payment;
            $newPayment->user_id  = Auth::id();
            $newPayment->data     = $payment;
            
            if( !$newPayment->save() ){
                throw new PaymentException ('payment not saved into database');
            }

            # Sum the credits to the user
            Auth::user()->SumCredits($payment['request']['purchase_units'][0]['amount']['value']);

            # Go to billing index
            return redirect()
                 ->route('desk.billing')
                 ->with([
                     'message' => __('Thank you for your buy. Enjoy your credits')
                 ]);

        } catch ( PaymentException $e ){

            Log::error( $e );

            # Go to billing index with errors
            return redirect()
                 ->route('desk.billing')
                 ->with([
                     'message' => __('Sorry, something was bad. If you have problems, contact support.')
                 ]);
        }
    }



    /**
     * This is where to go when payment is canceled
     * 
     * @param   Request $request
     * @return  RedirectResponse
     */
    public function Cancel( Request $request )
    {
        try {

            # Go to billing index with errors
            return redirect()
                 ->route('desk.billing')
                 ->with([
                     'message' => __('The payment was canceled.')
                 ]);

        } catch ( PaymentException $e ){

            Log::error( $e );

            # Go to billing index with errors
            return redirect()
                 ->route('desk.billing')
                 ->with([
                     'message' => __('Sorry, something was bad. If you have problems, contact support.')
                 ]);
        }
    }

}
