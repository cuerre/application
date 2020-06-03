<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Controllers\ExpressCheckoutController;
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
     * 
     * 
     */
    function __Construct( Request $request )
    {
        # Generate Paypal instance (express checkout)
        if ( $request->has('transaction') ){
            $this->checkout = new ExpressCheckoutController(
                $request->input('transaction')
            );
        }else{
            $this->checkout = new ExpressCheckoutController();
        }
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

            # Go to get an authorization
            $this->checkout->SetItem([
                'name'  => 'Credits package', 
                'price' => $request->input('credits'), 
                'desc'  => 'Package of credits for using ' . config('app.name'), 
                'qty'   => 1
            ])->GetPaymentAuthorization();

        } catch ( PaymentException $e ) {

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

        } catch ( PaymentException $e ) {

            Log::error( $e );
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
    public function Success( Request $request )
    {
        try {
            # Check token existance
            if( !$request->has('token') ){
                throw new PaymentException (
                    'TOKEN field was not found in response'
                );
            }

            # Get the transaction details
            $response = $this->checkout->GetPaymentDetails($request->token);

            # Convert response into a collection
            $response = collect($response);
    
            # Check if ACK field is present
            if( !$response->has('ACK') ){
                throw new PaymentException (
                    'ACK field was not found in response'
                );
            }

            # Check if payment failed
            $ack = strtoupper($response['ACK']);
            if ( !in_array($ack, ['SUCCESS', 'SUCCESSWITHWARNING']) ) {
                throw new PaymentException (
                    'ACK field is not "SUCCESS" or "SUCCESSWITHWARNING"'
                );
            }

            # Check if TOKEN and PAYERID fields are present
            if( !$response->has('TOKEN') || !$response->has('PAYERID')){
                throw new PaymentException (
                    'TOKEN or PAYERID field was not found in response'
                );
            }

            # Execute the real payment
            $paymentResult = $this->checkout->ExecutePayment( 
                $response['TOKEN'], 
                $response['PAYERID'] 
            );

            # Check if payment was done
            if ( empty($paymentResult) ){
                throw new PaymentException (
                    'Payment was not executed and failed'
                );
            }

            # Join all information
            $paymentData = [
                'details' => $response->toArray(),
                'result'  => $paymentResult 
            ];
    
            # Store the transaction into DB
            $payment           = new Payment;
            $payment->user_id  = Auth::id();
            $payment->data     = $paymentData;
            
            if( !$payment->save() ){
                throw new PaymentException (
                    'Payment not saved into database'
                );
            }

            # Sum the credits to the user
            Auth::user()->SumCredits($response['AMT']);

            # Go to billing index
            return redirect()
                 ->route('dashboard.billing')
                 ->with([
                     'message' => __('Thank you for your buy. Enjoy your credits')
                 ]);

        } catch ( PaymentException $e ){

            Log::error( $e );

            # Go to billing index with errors
            return redirect()
                 ->route('dashboard.billing')
                 ->with([
                     'message' => __('Sorry, something was bad. If you have problems, contact support.')
                 ]);
        }
    }

}
