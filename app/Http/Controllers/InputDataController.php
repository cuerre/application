<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BrowscapController;

class InputDataController extends Controller
{
    //
    public static function getInput ( Request $request ){
    
        return dd( BrowscapController::getBrowser() );
    
        return dd($request);
    
        return response($request->all(), 200)->send();
    
        //return view('welcome', )
    
    }
}
