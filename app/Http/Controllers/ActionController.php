<?php

namespace App\Http\Controllers;

use App\Code as Code;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\BrowscapController;

class ActionController extends Controller
{
    /**
     * Perform redirection to the targets in order
     *
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
                ->limit(1)
                ->get()
                ->recursive();
            
            # Check for results existance
            if ( $code->isEmpty() )
                throw new Exception('Code not found for given id');
                
            # Check fot 'data' field existance
            if ( !$code[0]->has('data') )
                throw new Exception('Data field not found for queried code');
                
            # Simplify data field var name
            $data = $code[0]['data'];
                
            if ( !$data->has('redirections') )
                throw new Exception('No redirections for this code');
                
            # Redirect for target 'any'
            $data['redirections']->each(function ($item){
                # Transform 'target' to lower case
                $target = Str::of( $item['target'] )
                    ->lower()
                    ->__toString();
                    
                # Go to the promoted site
                if ( $target === 'any' ) 
                    return redirect()
                        ->away($item['url'])
                        ->send();
            });
            
            # Redirect for platform specific target
            $data['redirections']->each(function ($item) use ($platform) {
                # Transform 'target' to lower case
                $target = Str::of( $item['target'] )
                    ->lower()
                    ->__toString();
                
                # Go to the promoted site
                if ( $target === $platform)
                    return redirect()
                        ->away($item['url'])
                        ->send();
            });
            
            # Redirect for target 'fallback'
            $data['redirections']->each(function ($item){
                # Transform 'target' to lower case
                $target = Str::of( $item['target'] )
                    ->lower()
                    ->__toString();
                    
                # Go to the promoted site
                if ( $target === 'fallback' ) 
                    return redirect()
                        ->away($item['url'])
                        ->send();
                        
                # Last change to redirect missed. register it
                throw new Exception('Fallback target not found on this code');
            });
            
        } catch ( Exception $e ) {
            report($e);
            
            # Redirect to our fallback page
            return redirect('redirect/failed')
                ->send();
        }
    }
    
    
}
