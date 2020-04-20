<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use BrowscapPHP\Browscap;

class BrowscapController extends Controller
{
    /**
     * Collect and parse all user's browser data 
     * and put them into a collection
     *
     * @return Laravel collection
     */
    public static function getBrowser()
    {
        try {
            # Call 'cache' and 'log' instances
            $cache = Cache::store('redis');
            $logger = Log::channel('null');

            # Look for the data of user's User-Agent into the cache
            $browscap = new Browscap($cache, $logger);
        
            # Transform data into a collection
            $data = collect( $browscap->getBrowser() )
                ->recursive();
                
            if ( $data->isEmpty() ){
                throw new Exception ('Browser data not retrieved from browscap');
            }
            
            # Return data when collected
            return $data;
            
        } catch (Exception $e) {
            Log::error($e->getMessage());
            
            return collect([]);
        }
    }
    
    
    
    /**
     * Collect and parse all user's browser data 
     * and put them into a JSON object
     *
     * @return JSON object
     */
    public static function getBrowserJson()
    {
        try {
            # Get the browser data
            $data = self::getBrowser();
            
            return $data->toJson();
            
        } catch (Exception $e) {
        
            Log::error($e->getMessage());

            return collect([])->toJson();
        }
    }

}
