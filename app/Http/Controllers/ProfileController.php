<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
        /**
        * Get all profile of the signed user
        *
        * @return 
        */
        public static function Get()
        {
            try {
                # We need the user ID
                $userId = Auth::id();
                
                # Retrieve all codes
                $profile = User::where('id', $userId)
                    ->first();
                
                # Convert results to collections
                $profile = collect( $profile )
                    ->recursive();
                
                return $profile;
                
            } catch ( Exception $e ){

                Log::error($e->getMessage());

                return collect([]);
            }
        }
        
        
        
        /**
        * Update the profile of signed user
        *
        * @return 
        */
        public static function Update( Request $request )
        {           
            try{
                # Retrieve the user
                $userId = Auth::id();
                
                # Check the input fields
                $validator = Validator::make($request->all(), [
                    'name'     => ['sometimes', 'required', 'string', 'max:100'],
                    'password' => ['sometimes', 'required', 'confirmed', 'string', 'max:100']
                ]);
                
                if ($validator->fails())
                    throw new Exception ('Some field is malformed');
                
                # Convert the input array into collection
                $validated = collect($validator->validated());
                
                # If password is present, hash it
                if( $validated->has('password') ){
                    $validated->put('password', Hash::make($validated['password']));
                }
                
                # Try to update data
                $affected = User::where('id', $userId)
                    ->update($validator->validated());
                    
                if( $affected !== 1 )
                    throw new Exception ('We could not update your profile');
                    
                # Go to the form with error bag
                return redirect('dashboard/profile')
                    ->send();
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());
                
                # Go to the form with error bag
                return redirect('dashboard/profile')
                    ->withErrors([
                        'message' => $e->getMessage()
                    ])
                    ->send();
            }
        }
        
        

        /**
        * Create new code
        *
        * @return Illuminate\Http\RedirectResponse
        */
        /*public static function CreateOne( Request $request )
        {
            try{
                
                # Retrieve the user
                $userId = 1;
                
                # Check the input fields
                $validator = Validator::make($request->all(), [
                    'name' => ['required', 'max:100'],
                    'targets' => ['required', 'array', 'min:1'],
                ]);
                
                if ($validator->fails())
                    throw new Exception ('Some field is malformed');
                    
                # Convert target to a collection
                $targets = collect( $request->input('targets') )->recursive();
                
                # Check data field
                $verifyTargets = $targets->every(function ($value, $key) {
                    if ( !is_int($key) )
                        return false;
                        
                    $validator = Validator::make($value->toArray(), [
                        'system' => ['required', 'alpha_num', 'filled'],
                        'url' => ['required', 'url', 'filled'],
                    ]);
                    
                    if ( $validator->fails() ){
                        return false;
                    }
                    return true;
                });
                
                if (!$verifyTargets)
                    throw new Exception ('Some field is malformed');
                    
                # Check if Any target is set
                $verifyAny = $targets->firstWhere('system', 'any');
                
                if ( is_null($verifyAny) )
                    throw new Exception ('You must define "Any" target. Remember that everything can fail.');
                
                # Format data field
                $data = collect([
                    'targets' => $targets
                ]);
                                
                # Add new code
                $code          = new Code;
                $code->user_id = $userId;
                $code->name    = $request->input('name');
                $code->data    = $data->toArray();
                
                if ( !$code->save() )
                    throw new Exception ('Failed to create the code');
                    
                # Go to the index
                return redirect('dashboard/codes')
                    ->send();
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());
                
                # Go to the form with error bag
                return redirect('dashboard/codes/creation')
                    ->withErrors([
                        'message' => $e->getMessage()
                    ])
                    ->send();
            }
        }
        */
        
        
        
        /**
        * Remove a code and all associated data
        *
        * @return bool
        */
        /*public static function DeleteOne( Request $request )
        {
            try{
                # We need the user ID
                $userId = 1;
                    
                # Check input data
                $validator = Validator::make($request->all(), [
                    'id' => ['required', 'integer', 'exists:codes'],
                ]);
                
                if ($validator->fails())
                    throw new Exception ('Some field is malformed');
                
                # Delete asked code
                $delete = Code::where('user_id', $userId)
                    ->where('id', $request->input('id'))
                    ->delete();
                    
                if (!$delete)
                    throw new Exception ('Code not deleted');
                    
                return redirect('dashboard/codes')
                    ->send();
                       
            } catch ( Exception $e ) {
                Log::error($e->getMessage());
                
                return redirect('dashboard/codes')
                    ->withErrors([
                        'message' => $e->getMessage()
                    ])
                    ->send();
            }
        }*/
     
     
     
        /**
        * Show the index view for profile
        *
        * @return 
        */
        public static function ViewIndex ()
        {
            try {
                # Get the codes collection and paginate them
                $profile = self::Get();

                # Show index view
                return view('modules.profile.index', ['profile' => $profile]);
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());

                abort(404);
            }
        }
        
        
        
        /**
        * Show the view to change name
        *
        * @return 
        */
        public static function ViewChangeName ()
        {
            try {

                # Show index view
                return view('modules.profile.change.name');
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());

                abort(404);
            }
        }
        
        
        
        /**
        * Show the view to change the password
        *
        * @return 
        */
        public static function ViewChangePassword ()
        {
            try {

                # Show index view
                return view('modules.profile.change.password');
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());

                abort(404);
            }
        }
      
      
      
       
}
