<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Exceptions\CuerreException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TokensController extends Controller
{
        /**
        * Get all tokens of the signed user
        *
        * @return 
        */
        public static function Get()
        {
            try {

                # Get all the tokens
                $tokens = Auth::user()->tokens;

                # Convert them into collection
                return collect($tokens);
                
            } catch ( CuerreException $e ){

                return collect([]);
            }
        }
        
        
        
        /**
        * Create a token for signed user
        *
        * @return 
        */
        public static function Create( Request $request )
        {           
            try{
                # Retrieve the user
                $user = Auth::user();
                
                # Check the input fields
                $validator = Validator::make($request->all(), [
                    'name'     => ['required', 'alpha_dash', 'max:100'],
                ]);
                
                if ($validator->fails())
                    throw new CuerreException ('Name is malformed');
                
                # Try create the token
                $token = $user->createToken($request->input('name'));

                # Go to the form with error bag
                return redirect()
                    ->back()
                    ->with([
                        'message' => $token->plainTextToken
                    ])
                    ->send();
                
            } catch ( CuerreException $e ) {

                # Go to the form with error bag
                return redirect()
                    ->back()
                    ->withErrors([
                        'message' => $e->getMessage()
                    ])
                    ->send();
            }
        }
        
        
        
        /**
        * Remove a profile
        *
        * @return bool
        */
        public static function Delete( Request $request )
        {
            try{
                # We need the user ID
                $user = Auth::user();

                # Check the input fields
                $validator = Validator::make($request->all(), [
                    'id'     => ['required', 'integer', 'exists:personal_access_tokens,id'],
                ]);

                if ($validator->fails())
                    throw new CuerreException ('We could not find your token');

                # Delete the token
                $delete = $user->tokens()->where('id', $request->input('id'))->delete();
                    
                if (!$delete)
                    throw new CuerreException ('We could not delete your token');
                
                # Go to tokens index
                return redirect()
                    ->back()
                    ->with([
                        'message' => 'Your token has been deleted'
                    ])
                    ->send();
                       
            } catch ( CuerreException $e ) {
                
                return redirect()
                    ->back()
                    ->withErrors([
                        'message' => $e->getMessage()
                    ])
                    ->send();
            }
        }
        
     
     
        /**
        * Show the index view for profile
        *
        * @return 
        */
        public static function ViewIndex ()
        {
            try {
                # Get the codes collection and paginate them
                $tokens = self::Get();

                # Show index view
                return view('modules.tokens.index', ['tokens' => $tokens]);
                
            } catch ( CuerreException $e ) {

                abort(404);
            }
        }



        /**
        * Show the creation view for tokens
        *
        * @return 
        */
        public static function ViewCreation ()
        {
            try {

                # Show index view
                return view('modules.tokens.creation');
                
            } catch ( CuerreException $e ) {

                abort(404);
            }
        }
        
        
        
        /**
        * Show the view to change name
        *
        * @return 
        */
        /*public static function ViewChangeName ()
        {
            try {
                # Show index view
                return view('modules.profile.change.name');
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());

                abort(404);
            }
        }*/
        

        
        /**
        * Show the view to delete the account
        *
        * @return 
        */
        public static function ViewDeletion ()
        {
            try {
                # Show index view
                return view('modules.profile.delete');
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());

                abort(404);
            }
        }
      
      
      
       
}
