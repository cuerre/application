<?php

namespace App\Http\Controllers;

use App\Code;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CodesController extends Controller
{
        /**
        * Get 
        *
        * @return 
        */
        public static function GetAll()
        {
            try {
                # We need the user ID
                $userId = 1;
                
                # Retrieve all codes
                $codes = Code::where('user_id', $userId)
                    ->get();
                
                # Convert results to collections
                $codes = collect( $codes )
                    ->recursive();
                
                return $codes;
                
            } catch ( Exception $e ){

                # Store the exception
                report ($e);

                # Return an empty collection    
                return collect([]);
            }
        }
        
        
        
        /**
        * Generate the URL to get 
        * a QR image from the api
        *
        * @return string
        */
        public static function GetImageUrl( int $codeId )
        {
            try{
                # Build the content of the code
                $codeContent = Str::of('')
                    ->append(url('redirect?c='))
                    ->append($codeId);
                
                # Build the url
                $codeUrl = Str::of('http://')
                    ->append(config('services.cuerre.api.host'))
                    ->append(':')
                    ->append(config('services.cuerre.api.port'))
                    ->append('/api/encode?data=')
                    ->append($codeContent);
               
                return $codeUrl;
                
            } catch ( Exception $e ) {
                report ($e);
            }
        }
        
        
        
        /**
        * Create new code
        *
        * @return Illuminate\Http\RedirectResponse
        */
        public static function CreateOne( Request $request )
        {
            try{
            
                # Check input data
                /*$validatedData = $request->validate([
                    'title' => ['required', 'unique:posts', 'max:255'],
                    'body' => ['required'],
                ]);*/
                  
            } catch ( Exception $e ) {

            }
        }
        
        
        
        /**
        * Remove a code and all associated data
        *
        * @return bool
        */
        public static function RemoveOne( int $codeId )
        {
            try{
                             
            } catch ( Exception $e ) {

            }
        }
     
     
     
        /**
        * Show the index view with codes
        *
        * @return 
        */
        public static function ViewIndex ()
        {
            try {
                # Get the codes collection and paginate them
                $codes = self::GetAll()->paginate(5);

                # Show index view
                return view('modules.codes.index', ['codes' => $codes]);
                
            } catch ( Exception $e ) {
                report ($e);

                abort(404);
            }
        }
      
      
      
       
}
