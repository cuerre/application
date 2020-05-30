<?php

namespace App\Http\Controllers;

use App\Exception\ExpressCheckoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\ExpressCheckout;

/** 
 * ExpressCheckoutController is a Laravel Controller for making punctual buys with PayPal API
 * 
 * ExpressCheckoutController is a Laravel Controller that uses Srmklive/PayPal 
 * library for making 'ExpressCheckout' transactions with the PayPal API 
 * and take the response
 * 
 * Example usage:
 * $buy = new ExpressCheckoutController ();
 * 
 * # Get payment authorization
 * $buy->SetItem([
 *      'name'  => 'Credits package', 
 *      'price' => 10, 
 *      'desc'  => 'Package of credits for using ' . config('app.name'), 
 *      'qty'   => 1
 * ])->GetPaymentAuthorization()
 * 
 * # Get payment details from response
 * $response = $buy->GetPaymentDetails($request->token);
 * 
 * # Execute real payment
 * $result = $buy->ExecutePayment( $response['TOKEN'], $response['PAYERID'] )
 * 
 * @package  Cuerre
 * @author   Alby Hernández
 * @version  $Revision: 1.0 $
 * @access   private
 * @see      http://cuerre.com/documentation
 */
class ExpressCheckoutController extends Controller
{
    /**
     * Instance of the library
     * Srmklive\PayPal
     * 
     * @var Srmklive\PayPal\Services\ExpressCheckout
     */
    private $provider;



    /**
     * Hash of current transaction
     * 
     * @var string
     */
    private $transaction;



    /**
     * Application data that
     * Paypal uses to show
     * 
     * @var array
     */
    private $checkoutOptions;



    /**
     * Invoice, items, total and
     * more data that Paypal requires
     * 
     * @var array
     */
    private $checkoutData;



    /**
     * 
     * 
     */
    function __Construct( $transaction = null )
    {
        try{
            # Init and store the payment provider
            $this->provider = new ExpressCheckout;

            # Define $checkoutData attribute as array
            $this->checkoutData = [];

            # Generate or not a new transaction ID
            if ( !is_null($transaction) ){
                if( !Str::isUuid($transaction) ){
                    throw new ExpressCheckoutException (
                        'Transaction ID is not a UUID'
                    );
                }
                $this->transaction = $transaction;
            }else{
                $this->transaction = (string) Str::uuid();
            }
            
            # Set callback URLs
            $this->checkoutData['return_url'] = route('payment.success', [
                'transaction' => $this->transaction
            ]);
            $this->checkoutData['cancel_url'] = route('payment.cancel');

            # Set invoice default values
            $this->checkoutData['invoice_id'] = $this->transaction;
            $this->checkoutData['invoice_description'] = 'Transaction #' . $this->transaction;
            $this->checkoutData['total'] = 0;

            # Set items cart
            $this->checkoutData['items'] = [];

            # Pimp the checkout screen
            $this->checkoutOptions = [
                'BRANDNAME'   => config('app.name'),
                'LOGOIMG'     => asset('imgs/logo-title.png'),
                'CHANNELTYPE' => 'Merchant'
            ];

        }catch( ExpressCheckoutException $e ){
            Log::error($e);
        }
    }



    /**
     * Return the SrmkLive provider
     * 
     * @return Srmklive\PayPal\Services\ExpressCheckout
     */
    public function GetProvider()
    {
        try {
            return $this->provider;
        } catch ( ExpressCheckoutException $e ){
            Log::error( $e );
        }
    }



    /** 
     * Calculate the total quantity
     * value of all items in the invoice
     * 
     * @return object $this
     */
    public function SetTotal()
    {
        try {
            $this->checkoutData['total'] = 0;

            # Transform the cart array to collection for ease
            $items = collect($this->checkoutData['items']);

            # Calculate the total price
            $this->checkoutData['total'] = $items
                ->map(function ($item) {
                    return $item['price'] * $item['qty'];
                })
                ->sum();

            return $this;

        } catch ( ExpressCheckoutException $e ){
            Log::error( $e );
            return $this;
        }
    }



    /**
     * Add an item to the invoice
     * 
     * @param  array  $item  
     * [
     *     'name' => string, 
     *     'price' => float, 
     *     'desc' => string, 
     *     'qty' => int
     * ]
     * @return object $this
     */
    public function SetItem ( array $item )
    {
        try {
            # Easier to work with collections
            $item = collect($item);

            # Check input item
            $validator = Validator::make($item->all(), [
                'name'   => ['required','string'],
                'price'  => ['required','numeric'],
                'desc'   => ['required','string'],
                'qty'    => ['required','integer']
            ]);

            # Store the item
            if( !$validator->fails() ){
                $this->checkoutData['items'][] = [
                    'name'  => $item['name'],
                    'price' => $item['price'],
                    'desc'  => $item['desc'],
                    'qty'   => $item['qty']
                ];
            }

            # Recalculate the total
            $this->SetTotal();

            # Return the object
            return $this;
            
        }catch ( ExpressCheckoutException $e ){
            Log::error( $e );
            return $this;
        }
    }



    /** 
     * Check and redirect to 
     * the payment request
     * 
     * @return RedirectResponse
     */
    public function GetPaymentAuthorization()
    {
        try {

            # Save checkout data into cache before leaving (during 5 minutes)
            $cachedCheckout = Cache::put(
                $this->transaction, 
                json_encode($this->checkoutData), 
                300
            );

            # Check if checkout is cached
            if ( !$cachedCheckout ){
                throw new ExpressCheckoutException (
                    'Checkout data were not cached'
                );
            }

            # Send the payment authorization request
            $response = $this->provider
                            ->addOptions($this->checkoutOptions)
                            ->setExpressCheckout($this->checkoutData);

            # Transform the response into collection for ease
            $response = collect($response);

            # Check redirection
            if ( !$response->has('paypal_link') ){
                throw new ExpressCheckoutException (
                    'Paypal redirection not defined'
                );
            }

            # Go to payment
            return redirect()->away($response['paypal_link'])->send();

        } catch ( ExpressCheckoutException $e ){
            Log::error( $e );

            # Payment error, go to safe callback
        }
    }



    /** 
     * Get payment details
     * 
     * @return array
     */
    public function GetPaymentDetails($token)
    {
        try {
            # Get the transaction details
            return $this->provider->getExpressCheckoutDetails($token);

        } catch ( ExpressCheckoutException $e ){
            Log::error( $e );
            return [];
        }
    }



    /** 
     * Execute the authorized 
     * cached payment
     * 
     * @return array
     */
    public function ExecutePayment( $token, $payerId )
    {
        try {
            # Get the transaction from the cache
            $cachedTransaction = Cache::get($this->transaction);

            # Check if transaction is cached
            if ( is_null($cachedTransaction) ){
                throw new ExpressCheckoutException ( 
                    'Selected transaction is not cached' 
                );
            }

            # Decode transaction
            $cachedTransaction = json_decode($cachedTransaction, true);

            # Check if decoding failed
            if ( is_null($cachedTransaction) ){
                throw new ExpressCheckoutException ( 
                    'Selected transaction was impossible to decode' 
                );
            }

            # Execute the payment and get the response
            $response = $this->provider->doExpressCheckoutPayment(
                $cachedTransaction, 
                $token, 
                $payerId
            );

            # Check the final response
            if ( is_null($response) || !is_array($response)  )
                throw new ExpressCheckoutException ( 
                    'Response was not a filled array' 
                );
            
            return $response;

        } catch ( ExpressCheckoutException $e ){
            Log::error( $e );
            return [];
        }
    }
   

}