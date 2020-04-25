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
        * Remove a profile
        *
        * @return bool
        */
        public static function Delete( Request $request )
        {
            try{
                # We need the user ID
                $userId = Auth::id();
                    
                # Delete asked profile
                $delete = User::where('id', $userId)
                    ->delete();
                    
                if (!$delete)
                    throw new Exception ('We could not delete your account');
                
                # Logout the user
                Auth::logout();
                
                # Go to register page
                return redirect('register')
                    ->send();
                       
            } catch ( Exception $e ) {
                Log::error($e->getMessage());
                
                return redirect('dashboard/profile')
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
