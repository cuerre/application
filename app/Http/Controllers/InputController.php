<?php

namespace App\Http\Controllers;

use App\StatBrowscap as StatBrowscap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\BrowscapController;

class InputController extends Controller
{
    /**
     * Collect and save all possible data 
     *
     * @return void
     *
     */
    public static function CollectData( Request $request )
    {
        try {
            ## Collect Browser data
            if( !self::CollectBrowser($request) )
                throw new Exception('Browser data not stored');
            
        } catch ( Exception $e ){
            report($e);
        }
    }
    
    
    
    /**
     * Collect and save browser data 
     *
     * @return bool
     *
     */
    public static function CollectBrowser (Request $request)
    {
        try {
            # Check for 'c' parameter on URI
            if ( !$request->has('c') ) 
                throw new Exception('URI parameter not defined');
            
            # Try to get the code
            $codeId = $request->query('c');
            
            # Generate a new visit hash
            $visitHash = Str::random(40);
            
            # Get all information about browser
            $browserData = BrowscapController::getBrowser();
            
            # Check for emptyness
            if ( $browserData->isEmpty() )
                throw new Exception('Browscap collection is empty');
            
            # Add visit hash to browscap and save data
            $browserData->put('visit_hash', $visitHash);
            
            $statBrowscap = new StatBrowscap;
            $statBrowscap->code_id = $codeId;
            $statBrowscap->data = $browserData->toJson();
            
            if ( !$statBrowscap->save() )
                throw new Exception('Impossible to save browser data');
            
        } catch ( Exception $e ){
            report($e);
            return false;
        }
        return true;
    }
    
    
    
}
