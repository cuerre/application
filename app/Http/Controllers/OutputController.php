<?php

namespace App\Http\Controllers;

use App\StatBrowscap as StatBrowscap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
//use Illuminate\Support\Facades\Log;
use App\Http\Controllers\StatsController;

class OutputController extends Controller
{
    /**
     *
     *
     *
     */
     function __Construct() 
     {
        
     }
     
     
    /**
     * 
     *
     * @return void
     *
     */
    public static function ViewTest( Request $request )
    {
        $stats = new StatsController(31);

        return view('modules.test',[
            'platforms'     => $stats->GetPlatforms(),
            'browsers'      => $stats->GetBrowsers(),
            'deviceTypes'   => $stats->GetDeviceTypes(),
            'browserTypes'  => $stats->GetBrowserTypes(),
        ]);
    }
    
    
    
    
    
}
