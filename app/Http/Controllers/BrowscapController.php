<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use BrowscapPHP\Browscap;

class BrowscapController extends Controller
{
    /**
     *
     *
     * @return Laravel collection
     */
    public static function getBrowser()
    {
        # Call 'cache' and 'log' instances
        $cache = Cache::store('redis');
        $logger = Log::channel('null');

        # Look for the data of user's User-Agent into the cache
        $browscap = new Browscap($cache, $logger);
        $info = $browscap->getBrowser();
        
        return dd($info);
    }

}
