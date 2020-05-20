<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Token;
use Illuminate\Support\Facades\Cache;

class CustomThrottle
{
    /**
     * Duration in seconds
     * of data stored in cache
     * 
     * @var int 
     */
    public $cacheDuration;



    /**
     * API key given 
     * in the request
     * 
     * @var string 
     */
    public $apikey;



    /**
     * Data stored into
     * 'apikey' cache key
     * 
     * @var array 
     */
    public $apikeyData;



    /**
     * Set initial values
     * 
     * @return void
     */
    public function __Construct()
    {
        $this->cacheDuration = now()->addMinutes(60);
        $this->apikey        = null;
        $this->apikeyData    = null;
    }



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {

            # Check the request looking for the API key
            self::CheckApikey($request);

            # Save the key
            self::SetApikey($request);

            # Look for the key into cache
            if ( !Cache::has( $this->apikey ) ) {

                # Check db existance
                if( !Token::Exists($this->apikey) ){
                    # @@@@@@@@@@@@@@
                    return dd('key dont exist');
                }

                # Take it from db
                $token = Token::where('token', $this->apikey)
                              ->first();

                # Check if we could get token
                if( is_null($token) ) {
                    throw new Exception ("Impossible to retrieve token data");
                }

                # Throw it into cache during a time
                $this->apikeyData = [
                    'active'       => $token->active,
                    'rate_limit'   => $token->rate_limit,
                    'rate_current' => 0,
                ];

                Cache::add($this->apikey, $this->apikeyData, $this->cacheDuration);
            }

            # Take apikey data from cache to test
            $this->apikeyData = Cache::get( $this->apikey );

            if( is_null($this->apikeyData) ) {
                throw new Exception ("Impossible to get data from cache");
            }

            # Reject requests when no more quota
            $rate_current = $this->apikeyData['rate_current'];
            $rate_limit   = $this->apikeyData['rate_limit'];

            if ( $rate_current >= $rate_limit) {
                # @@@@@@@@@@@@@@
                return dd('RATE MEH');
            }

            # Update the values on cache
            $this->apikeyData['rate_current'] += 1;
            Cache::put($this->apikey, $this->apikeyData);

            return dd($this->apikeyData);

            # Go to the next layer
            return $next($request);

        } catch( Exception $e ) {

        }
    }



    /**
     * Check if 'apikey' is present
     * 
     * @return bool
     */
    public static function CheckApikey( $request )
    {
        try{

            if ( !$request->filled('apikey') ){
                # @@@@@@@@@@@@@@
                return dd('no apikey');
            }

        } catch (Exception $e ){

        }
    }



    /**
     * Set 'apikey'
     * 
     * @return bool
     */
    public function SetApikey( $request )
    {
        try{

            $this->apikey = $request->query('apikey');

        } catch (Exception $e ){

        }
    }



    
}
