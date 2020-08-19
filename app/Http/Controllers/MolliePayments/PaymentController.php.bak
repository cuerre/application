<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Controllers\MolliePaymentController;
use App\Exceptions\PaymentException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * MolliePaymentController instance
     * 
     * @var MolliePaymentController
     */
    private $payment;



    /**
     * Create a new payment 
     * or try to retrieve the url's one
     * if present
     * 
     * @param Illuminate\Http\Request $request
     */
    function __Construct( Request $request )
    {
        # Generate Paypal instance (express checkout)
        if ( $request->has('payment') ){
            $this->payment = new MolliePaymentController(
                $request->input('payment')
            );
        }else{
            $this->payment = new MolliePaymentController();
        }
    }



    /**
     * Recieves an amount of credits as input and 
     * goes to Mollie to finish payment
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
            $this->payment
                 ->SetTotal( $request->input('credits') )
                 ->GetPayment();

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
     * This is 
     * 
     * @param   Request $request
     * @return  RedirectResponse
     */
    public function Webhook( Request $request )
    {
        try {

        } catch ( PaymentException $e ){
            Log::error( $e );
        }
    }


    /**
     * This is where to go when payment is done
     * to process and save it into our system
     * 
     * @param   Request $request
     * @return  RedirectResponse
     */
    public function Callback( Request $request )
    {
        try {

            # Get payment details
            $payment = $this->payment->GetPaymentDetails();

            # Check if we have details
            if ( is_null($payment) ){
                throw new PaymentException (
                    'Could not get the payment details'
                );
            }

            # Check if credits were paid
            if ( !$payment->isPaid() ){
                throw new PaymentException (
                    'Credits are not paid'
                );
            }

            # Join all information
            $paymentData = [
                'result'  => collect($payment)->toArray()
            ];
    
            # Store the transaction into DB
            $newPayment           = new Payment;
            $newPayment->user_id  = Auth::id();
            $newPayment->data     = $paymentData;
            
            if( !$newPayment->save() ){
                throw new PaymentException (
                    'Payment not saved into database'
                );
            }

            # Sum the credits to the user
            Auth::user()->SumCredits($payment->amount->value);

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

}
