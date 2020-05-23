<?php

namespace App\Http\Middleware;

use Exception;
use Closure;
use App\Token;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

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

            # Check the request for the API key 
            if( !$this->GetApikey($request) ){
                return response()->json([
                    'status'  => 'error',
                    'message' => 'apikey is missing'
                ], 400);
            }

            # Dump data from database to cache
            if( !Redis::exists($this->apikey) ) {
                if( !$this->SetCacheFromDatabase() ){
                    throw new Exception ('Error dumping data from db to cache');
                }
            }
            
            # Get the cached data 
            if( !$this->GetDataFromCache() ){
                throw new Exception ('Error setting attributes from cache');
            }

            # Check request rate
            if( !$this->isUnderRate() ){
                return response()->json([
                    'status'  => 'error',
                    'message' => 'apikey is missing'
                ], 400)->header();
            }

            # Increase rate counter
            if( !$this->increaseRate() ){
                throw new Exception ('Error increasing rate into cache');
            }

            # Get the cached data 
            if( !$this->GetDataFromCache() ){
                throw new Exception ('Error setting attributes from cache');
            }

            # Add some custom headers
            $remaining = $this->rateLimit - $this->rateCurrent;
            header('X-Rate-Limit-Limit: ' . $this->rateLimit);
            header('X-Rate-Limit-Remaining: ' . $remaining );
            //header('X-Rate-Limit-Reset: ' . 10);
            
            

            return dd( Redis::get($this->apikey) );

            # Go to the next layer
            return $next($request);

        } catch( Exception $e ) {
            Log::error( $e->getMessage() );

            # Send feedback to the user
            return response()->json([
                'status'  => 'error',
                'message' => 'we made a mistake'
            ], 500);

        }
    }



    /**
     * Check if 'apikey' is present 
     * on the request and save it 
     * into the instance
     * 
     * @return bool
     */
    public function GetApikey( $request )
    {
        try{
            if ( !$request->filled('apikey') )
                return false;

            $this->apikey = $request->input('apikey');
            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * Take data for the requested 
     * Apikey from database and store 
     * them into the cache
     * 
     * @return bool
     */
    public function SetCacheFromDatabase()
    {
        try{
            # Take it from db
            $token = Token::where('token', $this->apikey)->first();

            # Check if we could get token
            if( is_null($token) )
                return false;

            # Throw data into cache
            $expiracyMoment = Carbon::now()->addMinutes(1);
            $cached = Redis::set(
                $this->apikey, 
                json_encode([
                    'isActive'     => $token->active,
                    'createdAt'    => Carbon::now()->toDateTimeString(),
                    'expiredAt'    => $expiracyMoment->toDateTimeString(),
                    'rateCurrent'  => 0,
                    'rateLimit'    => $token->rate_limit,
                ]) 
            );

            # Set expiracy
            $expiracy = Redis::expireAt($this->apikey, $expiracyMoment->timestamp);

            # Cache failed to store the data
            if ( !$cached || !$expiracy )
                throw new Exception ( "Cache failed when using Cache:add()" );
            
            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * Take cached data for the 
     * requested 'Apikey' and store 
     * them into the instance
     * 
     * @return bool
     */
    public function GetDataFromCache()
    {
        try {
            # Take data from cache
            $cached = Redis::get( $this->apikey );

            # No data stored for that key
            if( !$cached )
                return false;

            # Cast data from JSON to array
            $data = json_decode($cached, true);

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
     * Check if the Apitoken stored 
     * in the instance admits more requests
     * 
     * @return bool
     */
    public function isUnderRate()
    {
        try {
            # Reject requests when no more quota
            if ( !($this->rateCurrent < $this->rateLimit) )
                return false;

            return true; 

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    /**
     * Increase one request on the 
     * 'rateCurrent' value into cache
     * and into the instance
     * 
     * @return bool
     */
    public function increaseRate()
    {
        try {
            # Update the values on cache
            $this->rateCurrent++;

            # Save new values into the cache
            $reCached = Redis::set(
                $this->apikey, 
                json_encode([
                    'isActive'     => $this->isActive,
                    'createdAt'    => $this->createdAt->toDateTimeString(),
                    'expiredAt'    => $this->expiredAt->toDateTimeString(),
                    'rateCurrent'  => $this->rateCurrent,
                    'rateLimit'    => $this->rateLimit,
                ]) 
            );

            # Set the expiracy again
            $expiracy = Redis::expireAt(
                $this->apikey, 
                $this->expiredAt->timestamp
            );

            $refresh = $this->GetDataFromCache();

            if( !$reCached || !$expiracy )
                return false;

            return true;

        } catch (Exception $e ){
            Log::error( $e->getMessage() );
            return false;
        }
    }



    
}
