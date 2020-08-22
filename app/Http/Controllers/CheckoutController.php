<?php

namespace App\Http\Controllers;

use App\Exceptions\PaymentException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

# Paypal SDK
use PayPalCheckoutSdk\Core\PayPalHttpClient;
#use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;


/** 
 * 
 * @package  Cuerre
 * @author   Alby Hernández
 * @version  $Revision: 1.0 $
 * @access   private
 * @see      http://cuerre.com/documentation
 */
class CheckoutController extends Controller
{
    // Creating an environment
    private $clientId = null;
    private $clientSecret = null;



    /**
     * Instance of the Paypal SDK client
     * 
     * @var 
     */
    private $client;



    /**
     * Hash of current payment
     * 
     * @var string
     */
    private $paymentHash;



    /**
     * Data that Paypal requires
     * on the request
     * 
     * @var array
     */
    private $paymentData;



    /**
     * 
     * 
     */
    function __Construct( $paymentHash = null )
    {
        try{
            $this->clientId     = config('paypal.client.id');
            $this->clientSecret = config('paypal.client.secret');

            # Start the environment
            #$environment = new SandboxEnvironment($this->clientId, $this->clientSecret);
            $environment = new ProductionEnvironment($this->clientId, $this->clientSecret);
            $this->client = new PayPalHttpClient($environment);

            # Define $checkoutData attribute as array
            $this->paymentData = [];

            # Generate or not a new payment ID
            if ( !is_null($paymentHash) ){
                if( !Str::isUuid($paymentHash) ){
                    throw new PaymentException (
                        'Transaction ID is not a UUID'
                    );
                }
                $this->paymentHash = $paymentHash;
            }else{
                $this->paymentHash = (string) Str::uuid();
            }
            
            # Set default values for the invoice
            $this->paymentData['request'] = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => "Credits package #" . $this->paymentHash,
                    "amount" => [
                        "value" => 0,
                        "currency_code" => "EUR"
                    ]
                ]],
                "application_context" => [
                    "cancel_url" => route('payment.cancel'),
                    "return_url" => route('payment.return', [
                        'paymentHash' => $this->paymentHash
                    ])
                ]
            ];
        
        }catch( PaymentException $e ){
            Log::error($e);
        }
    }



    /**
     * Return the client instance
     * 
     * @return
     */
    public function GetClient()
    {
        try {
            return $this->client;
        } catch ( PaymentException $e ){
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
                $this->paymentData['request']['purchase_units'][0]['amount']['value'] = $amount;

            return $this;

        } catch ( PaymentException $e ){
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
    public function SetPayment()
    {
        try {
            # Create a Payment request
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = $this->paymentData['request'];

            # Try to execute the payment
            $order = $this->client->execute($request);

            # Store payment ID into attributes
            $this->paymentData['order'] = $order;

            # Save payment data into cache before leaving (during 5 minutes)
            $cachedPayment = Cache::put(
                $this->paymentHash, 
                json_encode($this->paymentData), 
                300
            );

            # Check if checkout is cached
            if ( !$cachedPayment ){
                throw new PaymentException ('payment data were not cached');
            }

            # Take the approval link
            $approvalUrl = null;
            foreach($order->result->links as $link){
                if($link->rel == 'approve'){
                    $approvalUrl = $link->href;
                }
            }

            # Check the approval link
            if ( empty($approvalUrl) ){
                throw new PaymentException('no approval link recieved on the response');
            }

            # Go to pay
            return redirect()->away($approvalUrl)->send();

        } catch ( PaymentException $e ){
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
     * Get payment details from cache
     * 
     * @return array|null
     */
    public function GetPayment()
    {
        try {

            # Get the transaction from the cache
            $cachedPayment = Cache::get($this->paymentHash);

            # Check if payment is cached
            if ( empty($cachedPayment) ){
                throw new PaymentException ('selected payment is not cached');
            }

            # Decode payment
            $cachedPayment = json_decode($cachedPayment, true);

            # Check if decoding failed
            if ( empty($cachedPayment) ){
                throw new PaymentException ('selected payment was impossible to decode');
            }

            # Get the checkout's outcome 
            $order = new OrdersCaptureRequest($cachedPayment['order']['result']['id']);
            $order->prefer('return=representation');
            $outcome = $this->client->execute($order);

            # Check if checkout outcome is present
            if ( empty($outcome) ){
                throw new PaymentException ('selected payment has not any result');
            }

            # Add the checkout's outcome to the payment data
            $cachedPayment['outcome'] = collect($outcome)->toArray();

            # Return payment details
            return collect($cachedPayment)->recursive()->toArray();

        } catch ( PaymentException | HttpException $e ){
            Log::error( $e );
            return null;
        }
    }




}
