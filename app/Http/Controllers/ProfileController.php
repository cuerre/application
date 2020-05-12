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

/** 
 * ProfileController is a Laravel Controller for managing App\User Models and Views
 * 
 * ProfileController is a Laravel Controller for managing App\User data Models 
 * and renderable Views. This means that everything related to url('dashboard/profile')
 * can be found here. This controller tries to keep all methods as static.
 * 
 * Example usage:
 * ProfileController::Get()
 * ProfileController::Update( Request )
 * ProfileController::Delete( Request )
 * ProfileController::ViewIndex()
 * ProfileController::ViewChangeName()
 * ProfileController::ViewChangePassword( )
 * ProfileController::ViewDeletion()
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class ProfileController extends Controller
{
    /**
    * Get profile of the signed user
    *
    * @return Illuminate\Support\Collection
    */
    public static function Get()
    {
        try {
            # We need the user ID
            $userId = Auth::id();
            
            # Retrieve profile
            $profile = User::where('id', $userId)->first();
            
            # Convert results to collections
            $profile = collect( $profile )->recursive();
            
            return $profile;
            
        } catch ( Exception $e ){

            Log::error($e->getMessage());

            return collect([]);
        }
    }
    
    /**
    * Update the profile of signed user
    *
    * @param  \Illuminate\Http\Request
    * @return  \Illuminate\Http\RedirectResponse
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
            
            if ($validator->fails()){
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('Some field is malformed')
                        ])
                        ->send();
            }
            
            # Convert the input array into collection
            $validated = collect($validator->validated());
            
            # If password is present, hash it
            if( $validated->has('password') ){
                $validated->put('password', Hash::make($validated['password']));
            }
            
            # Try to update data
            $affected = User::where('id', $userId)
                ->update($validator->validated());
                
            if( $affected !== 1 ){
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('Sorry, we could not change your profile')
                        ])
                        ->send();
            }
                
            # Go to the index
            return redirect('dashboard/profile')
                    ->send();
            
        } catch ( Exception $e ) {
            Log::error($e->getMessage());
            
            # Go to the form with error bag
            return redirect()
                    ->back()
                    ->withErrors([
                        'message' => __('Something went wrong')
                    ])
                    ->send();
        }
    }
    
    /**
    * Remove a profile from the system
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public static function Delete( Request $request )
    {
        try{
            # We need the user ID
            $userId = Auth::id();

            # Check the password
            $validator = Validator::make($request->all(), [
                'password' => ['password:web', 'required']
            ]);
            
            if ($validator->fails()){
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('The password is not right')
                        ])
                        ->send();
            }
                
            # Delete asked profile
            $delete = User::where('id', $userId)->delete();
                
            if (!$delete){
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('User could not be deleted')
                        ])
                        ->send();
            }
            
            # Logout the user
            Auth::logout();
            
            # Go to register page
            return redirect('register')
                    ->send();
                    
        } catch ( Exception $e ) {
            Log::error($e->getMessage());
            
            return redirect()
                    ->back()
                    ->withErrors([
                        'message' => 'Something went wrong'
                    ])
                    ->send();
        }
    }
    
    /**
    * Show the index view for profile
    *
    * @return  Illuminate\Contracts\View\View
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
    * @return  Illuminate\Contracts\View\View
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
    * @return  Illuminate\Contracts\View\View
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
    * @return  Illuminate\Contracts\View\View
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
