<?php

namespace App\Http\Controllers;

use App\StatBrowscap as StatBrowscap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BrowscapController;

class OutputController extends Controller
{
    /**
     * 
     *
     * @return void
     *
     */
    public static function ViewTest( Request $request )
    {
        return view('modules.test');
    }
    
    
    
    
    
}
