<?php

namespace App\Http\Controllers;

//use App\Exceptions\Exception;
//use Exception;
use App\Exceptions\MolliePaymentException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mollie\Api\MollieApiClient;


/** 
 * 
 * @package  Cuerre
 * @author   Alby Hernández
 * @version  $Revision: 1.0 $
 * @access   private
 * @see      http://cuerre.com/documentation
 */
class MolliePaymentController extends Controller
{
    /**
     * Instance of the library
     * \Mollie\Api\MollieApiClient
     * 
     * @var 
     */
    private $mollie;



    /**
     * Hash of current payment
     * 
     * @var string
     */
    private $payment;



    /**
     * Description, total and
     * more data that Mollie requires
     * 
     * @var array
     */
    private $paymentData;



    /**
     * 
     * 
     */
    function __Construct( $payment = null )
    {
        try{
            # Init and store the payment provider
            $this->mollie = new MollieApiClient;
            $this->mollie->setApiKey("test_FQnhF3fTQKgUw6JbN9JxpqSr9bGD9n");

            # Define $checkoutData attribute as array
            $this->paymentData = [];

            # Generate or not a new payment ID
            if ( !is_null($payment) ){
                if( !Str::isUuid($payment) ){
                    throw new MolliePaymentException (
                        'Transaction ID is not a UUID'
                    );
                }
                $this->payment = $payment;
            }else{
                $this->payment = (string) Str::uuid();
            }
            
            # Set callback URLs
            $this->paymentData['redirectUrl'] = route('payment.callback', [
                'payment' => $this->payment
            ]);

            $this->paymentData['webhookUrl'] = route('payment.webhook', [
                'payment' => $this->payment
            ]);

            # Set invoice default values
            $this->paymentData['description'] = 'Credits package #' . $this->payment;
            $this->paymentData['amount']['currency'] = 'EUR';
            $this->paymentData['amount']['value'] = 0;
        
        }catch( MolliePaymentException $e ){
            Log::error($e);
        }
    }



    /**
     * Return the 
     * 
     * @return
     */
    public function GetMollie()
    {
        try {
            return $this->mollie;
        } catch ( MolliePaymentException $e ){
            Log::error( $e );
        }
    }



    /** 
     * Change the total of this
     * payment
     * 
     * @return object $this
     */
    public function SetTotal( $amount = null )
    {
        try {
            if ( !is_null($amount) && is_numeric($amount) )

                $amount = round($amount, 2);
                $amount = number_format($amount, 2, '.', '');
                $this->paymentData['amount']['value'] = $amount;

            return $this;

        } catch ( MolliePaymentException $e ){
            Log::error( $e );
            return $this;
        }
    }



    /** 
     * Save this payment into 
     * cache during 5 minutes and 
     * go to payment page
     * 
     * @return Illuminate\Http\RedirecResponse
     */
    public function GetPayment()
    {
        try {

            # Create the payment
            $payment = $this->mollie->payments->create(
                $this->paymentData
            );

            # Store Mollie's Payment ID into attributes
            $this->paymentData['id'] = $payment->id;

            # Save payment data into cache before leaving (during 5 minutes)
            $cachedPayment = Cache::put(
                $this->payment, 
                json_encode($this->paymentData), 
                300
            );

            # Check if checkout is cached
            if ( !$cachedPayment ){
                throw new MolliePaymentException (
                    'Payment data were not cached'
                );
            }

            # Go to pay
            return redirect()->away($payment->getCheckoutUrl())->send();

        } catch ( MolliePaymentException $e ){
            Log::error( $e );

            # Go to billing page
            return redirect()
                 ->route('dashboard.billing')
                 ->with([
                     'message' => __('Impossible to create the payment. Contact our support team.')
                 ]);
        }
    }



    /** 
     * Get payment details
     * 
     * @return Mollie\Api\Resources\Payment|null
     */
    public function GetPaymentDetails()
    {
        try {

            # Get the transaction from the cache
            $cachedPayment = Cache::get($this->payment);

            # Check if payment is cached
            if ( is_null($cachedPayment) ){
                throw new MolliePaymentException ( 
                    'Selected payment is not cached' 
                );
            }

            # Decode payment
            $cachedPayment = json_decode($cachedPayment, true);

            # Check if decoding failed
            if ( is_null($cachedPayment) ){
                throw new MolliePaymentException ( 
                    'Selected payment was impossible to decode' 
                );
            }

            # Get payment details
            return $this->mollie->payments->get($cachedPayment['id']);

        } catch ( MolliePaymentException $e ){
            Log::error( $e );
            return null;
        }
    }




}
