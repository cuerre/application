<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\ExpressCheckout;

/** 
 * CheckoutController is a Laravel Controller for making punctual buys with PayPal API
 * 
 * CheckoutController is a Laravel Controller that uses Srmklive/PayPal 
 * library for making 'ExpressCheckout' transactions with the PayPal API 
 * and take the response
 * 
 * Example usage:
 * $buy = new CheckoutController ();
 * 
 * # New payment
 * $buy->SetInvoice([
 *      'id'   => $invoideId, 
 *      'desc' => 'Order #'.$invoideId, 
 * ])->SetItem([
 *      'name'  => 'Credits package', 
 *      'price' => 10, 
 *      'desc'  => 'Package of credits for using ' . config('app.name'), 
 *      'qty'   => 1
 * ])->SetPayment()
 * 
 * # Get payment details from response
 * $response = $buy->GetPayment($request->token);
 * 
 * @package  Cuerre
 * @author   Alby Hernández
 * @version  $Revision: 1.0 $
 * @access   private
 * @see      http://cuerre.com/documentation
 */
class CheckoutController extends Controller
{
    /**
     * 
     * 
     */
    private $provider;

    /**
     * 
     * 
     */
    private $checkoutOptions;

    /**
     * 
     * 
     */
    private $checkoutData;

    /**
     * 
     * 
     */
    function __Construct()
    {
        # Init and store the payment provider
        $this->provider = new ExpressCheckout;

        # Define $checkoutData attribute as array
        $this->checkoutData = [];

        # Set callback URLs
        $this->checkoutData['return_url'] = route('payment.success');
        $this->checkoutData['cancel_url'] = route('payment.cancel');

        # Set invoice default values
        $this->checkoutData['invoice_id'] = 0;
        $this->checkoutData['invoice_description'] = 'Buying credits';

        # Set items cart
        $this->checkoutData['items'] = [];

        # Pimp the checkout screen
        $this->checkoutOptions = [
            'BRANDNAME'   => config('app.name'),
            'LOGOIMG'     => asset('imgs/logo-title.png'),
            'CHANNELTYPE' => 'Merchant'
        ];
    }

    /**
     * Return the SrmkLive provider
     * 
     * @return ExpressCheckout
     */
    public function GetProvider()
    {
        return $this->provider;
    }

    /**
     * Set header params for invoice
     * 
     * @param  Array  $item  
     * [
     *     'id'   => integer, 
     *     'desc' => string, 
     * ]
     * @return Object $this
     * 
     */
    function SetInvoice ( array $item )
    {
        try {
            # Easier to work with collections
            $item = collect($item);

            # Check input item
            $validator = Validator::make($item->all(), [
                'id'     => ['required','integer'],
                'desc'   => ['required','string'],
            ]);

            # Store the item
            if( !$validator->fails() ){
                $this->checkoutData['invoice_id'] = $item['id'];
                $this->checkoutData['invoice_description'] = $item['desc'];
            }

            # Return this object
            return $this;

        } catch ( Exception $e ){
            Log::error( $e->getMessage() );
            return $this;
        }
    }

    /**
     * Add an item to the shopping cart
     * 
     * @param  Array  $item  
     * [
     *     'name' => string, 
     *     'price' => float, 
     *     'desc' => string, 
     *     'qty' => int
     * ]
     * @return Object $this
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

            # Return the object
            return $this;
            
        }catch ( Exception $e ){
            Log::error( $e->getMessage() );
            return $this;
        }
    }

    /** 
     * Check and redirect to 
     * the payment request
     * 
     * @return RedirectResponse
     */
    public function SetPayment()
    {
        try {
            # Transform the cart array to collection for ease
            $items = collect($this->checkoutData['items']);

            # Calculate the total price
            $this->checkoutData['total'] = $items
                ->map(function ($item) {
                    return $item['price'] * $item['qty'];
                })
                ->sum();

            # Send the payment request
            
            $response = $this->provider
                ->addOptions($this->checkoutOptions)
                ->setExpressCheckout($this->checkoutData);

            # Transform the response into collection for ease
            $response = collect($response);

            # Check redirection
            if ( !$response->has('paypal_link') ){
                throw new Exception ('Payment(): Paypal redirection not defined');
            }

            # Go to payment
            redirect()
                ->away($response['paypal_link'])
                ->send();

        } catch ( Exception $e ){
            Log::error( $e->getMessage() );

            # Payment error, go to safe callback
            //return dd($response); //redirect();
            //return dd('fallaste wey:' . $e->getMessage()); //redirect();
        }
    }

    /** 
     * Get payment details
     * 
     * @return RedirectResponse
     */
    public function GetPayment($token)
    {
        try {
            # Get the transaction details
            return $this->provider->getExpressCheckoutDetails($token);

        } catch ( Exception $e ){
            Log::error( $e->getMessage() );

        }
    }
   

}