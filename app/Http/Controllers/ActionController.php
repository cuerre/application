<?php

namespace App\Http\Controllers;

use Exception;
use App\Code;
//use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\BrowscapController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

/** 
 * ActionController is who controls what to do after visits
 * 
 * ActionController is a Controller that make some type of action
 * after processing the request into the pipeline. 
 * For example: redirect to the target
 * 
 * Example usage:
 * ActionController::Redirect( Request )
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class ActionController extends Controller
{
    /**
     * Perform redirection to the targets in order
     *
     * @param  Illuminate\Http\Request
     * @return Illuminate\Http\RedirectResponse
     */
    public static function Redirect (Request $request)
    {
        try {
            # Get the code_id from URI params
            $codeId = $request->query('c', -1);
            
            # Get current request browser data
            $browser = BrowscapController::getBrowser();
            
            # Convert current 'platform' to lowercase
            $platform = Str::of( $browser['platform'] )
                            ->lower()
                            ->__toString();
            
            # Get requested code as collection from database
            $code = Code::where('id', $codeId)
                        ->first();

            $code = collect($code)->recursive();
            
            # Check for results existance
            if ( $code->isEmpty() )
                throw new Exception('Code not found for given id');

            # Check the status of the code
            if ( $code['active'] == false )
                throw new Exception('Code not active');
              
            # Check fot 'data' field existance
            if ( !$code->has('data') )
                throw new Exception('Data field not found for queried code');

            if ( !$code['data']->has('targets') )
                throw new Exception('No targets for this code');

            # Redirect for platform specific target
            $code['data']['targets']->each(function ($item, $key) use ($platform) {
                # http://192.168.0.42:8000/redirect?c=22
                
                # Transform 'target' to lower case
                $target = Str::of( $item['system'] )
                            ->lower()
                            ->__toString();
                
                # Go to the promoted site
                if ( $target === $platform )
                    return redirect()
                            ->away($item['url'])
                            ->send();
            });
                
            # Redirect for target 'any'
            $code['data']['targets']->each(function ($item, $key){
                # Transform 'target' to lower case
                $target = Str::of( $item['system'] )
                            ->lower()
                            ->__toString();
                    
                # Go to the promoted site
                if ( $target === 'any' ) 
                    return redirect()
                            ->away($item['url'])
                            ->send();
            });
            
            throw new Exception('Target "any" not configured. Redirection failed.');
            
        } catch ( Exception $e ) {
        
            Log::emergency($e->getMessage());
                   
            # Redirect to our fallback page
            return redirect('redirect/failed')
                   ->send();
        }
    }
    
    
}
