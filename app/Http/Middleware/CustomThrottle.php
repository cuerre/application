<?php

namespace App\Http\Middleware;

use Exception;
use Closure;
use App\Token;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CustomThrottle 
{
    /**
     * API key given 
     * in the request
     * 
     * @var string 
     */
    public $apikey;



    /**
     * Flag to know if the token 
     * is was active into DB when 
     * stored in cache
     * 
     * @var bool 
     */
    public $isActive;



    /**
     * The moment the apikey
     * was stores into cache
     * 
     * @var Carbon\Carbon
     */
    public $createdAt;



    /**
     * The moment the apikey
     * will be expired from 
     * the moment it was stored
     * 
     * @var Carbon\Carbon
     */
    public $expiredAt;



    /**
     * Number of requests done
     * 
     * @var int 
     */
    public $rateCurrent;



    /**
     * Number of maximun
     * possible requests
     * 
     * @var int 
     */
    public $rateLimit;



    /**
     * Set initial values
     * 
     * @return void
     */
    public function __Construct()
    {
        $this->apikey        = null;
        $this->isActive      = false;
        $this->createdAt     = null;
        $this->expiredAt     = null;
        $this->rateCurrent   = null;
        $this->rateLimit     = null;
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
            if( !$this->CheckApikey($request) ){
                return dd('No api key');
            }

            # Refresh cache if not cached
            # and store them into the instance
            if( !Cache::has( $this->apikey ) ) {
                if( !$this->RefreshCache() ){
                    return dd('No se pudo cachear la petición');
                }
            }
            
            # If cached, get the cached data 
            # and store them into the instance
            if( !$this->GetCachedData() ){
                return dd('El cache está jodido');
            }

            # If expired, refresh cache data
            # and store them into the instance
            if( $this->isExpired() ){
                Cache::forget( $this->apikey );
                if( ! $this->RefreshCache() ){
                    return dd('No se pudo cachear la petición');
                }
            }

            # Check request rate
            if( !self::isUnderRate() ){
                return dd('limit reached');
            }

            # Increase rate counter
            if( !$this->increaseRate() ){
                return dd('no se pudo aumentar el rate');
            }

            return dd([ Cache::get($this->apikey) ]);

            # Add some custom headers
            /*
            response()
                ->header('X-Rate-Limit-Limit', 5)
                ->header('X-Rate-Limit-Remaining', 2)
                ->header('X-Rate-Limit-Reset', 10);
            */

            //return dd($this->rateCurrent);

            # Go to the next layer
            return $next($request);

        } catch( Exception $e ) {

        }
    }



    /**
     * Check if 'apikey' is present 
     * and save it into attributes
     * 
     * @return bool
     */
    public function CheckApikey( $request )
    {
        try{

            if ( !$request->filled('apikey') ){
                return false;
            }

            $this->apikey = $request->input('apikey');
            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * C
     * 
     * @return bool
     */
    public function SetCacheFromDatabase()
    {
        try{

            # Take it from db
            $token = Token::where('token', $this->apikey)->first();

            # Check if we could get token
            if( is_null($token) ) {
                return false;
            }

            # Process data a bit
            $data = [
                'isActive'     => $token->active,
                'createdAt'    => Carbon::now(),
                'expiredAt'    => Carbon::now()->addMinutes(2),
                'rateCurrent'  => 0,
                'rateLimit'    => $token->rate_limit,
            ];

            # Throw it into cache
            //Cache::forget( $this->apikey );
            $cached = Cache::put($this->apikey, $data);

            # Cache failed to store the data
            if ( !$cached ){
                throw new Exception ( "Cache failed when using Cache:add()" );
            }
            
            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * C
     * 
     * @return bool
     */
    public function GetCachedData()
    {
        try {
            # Take data from cache
            $data = Cache::get( $this->apikey );

            # No data stored for that key
            if( is_null($data) ) {
                return false;
            }

            # Store values on the current instance
            $this->isActive      = $data['isActive'];
            $this->createdAt     = Carbon::parse($data['createdAt']);
            $this->expiredAt     = Carbon::parse($data['expiredAt']);
            $this->rateCurrent   = $data['rateCurrent'];
            $this->rateLimit     = $data['rateLimit'];

            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * C
     * 
     * @return bool
     */
    public function isExpired()
    {
        try {
            # Reject requests when expired
            if ( Carbon::now()->isAfter($this->expiredAt) ) {
                return true;
            }

            return false;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return true;
        }
    }



    /**
     * C
     * 
     * @return bool
     */
    public function isUnderRate()
    {
        try {

            # Reject requests when no more quota
            if ( $this->rateCurrent >= $this->rateLimit ) {
                return false;
            }

            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * C
     * 
     * @return bool
     */
    public function increaseRate()
    {
        try {

            # Update the values on cache
            $this->rateCurrent++;

            $data = [
                'isActive'     => $this->isActive,
                'createdAt'    => $this->createdAt,
                'expiredAt'    => $this->expiredAt,
                'rateCurrent'  => $this->rateCurrent,
                'rateLimit'    => $this->rateLimit,
            ];

            if( !Cache::put($this->apikey, $data) ){
                return false;
            }

            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * 
     * 
     * @return bool
     */
    public function RefreshCache ()
    {
        try {

            # Take data from database and set
            # them into cache
            if( !$this->SetCacheFromDatabase() ){
                throw new Exception ('Impossible to update cache from db');
            }

            # Get the cached data and store 
            # them into the instance attributes
            if( !$this->GetCachedData() ){
                throw new Exception ('Impossible to update instance attributes from cache');
            }

            return true;

        } catch ( Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    
}
