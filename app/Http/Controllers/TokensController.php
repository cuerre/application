<?php

namespace App\Http\Controllers;

use Exception;
use App\Exceptions\TokenException;
use App\Token;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/** 
 * TokensController is a Laravel Controller for managing App\Token Models and Views
 * 
 * TokensController is a Laravel Controller for managing App\Token data Models 
 * and renderable Views. This means that everything related to url('dashboard/tokens')
 * can be found here. This controller tries to keep all methods as static.
 * 
 * Example usage:
 * self::Get()
 * self::Create( Request )
 * self::Delete( Request )
 * self::Switch( int )
 * self::ViewIndex()
 * self::ViewCreation()
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class TokensController extends Controller
{
    /**
     * Get all tokens of the signed user
     *
     * @return Collection
     */
    public static function Get()
    {
        try {
            return Token::where('user_id', Auth::id())
                        ->get();
            
        } catch ( Exception $e ){

            return collect([]);
        }
    }
        
        
        
    /**
     * Create a token for signed user
     * CAUTION: Not encoded tokens yet
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function Create( Request $request )
    {           
        try{
            
            # Check the input fields
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required', 
                    'alpha_dash', 
                    'max:100'
                ],
            ]);
            
            if ($validator->fails())
                throw new TokenException ('Name is malformed');
            
            # Try create the token
            $token             = new Token;
            $token->user_id    = Auth::id();
            $token->name       = $request->input('name');
            $token->token      = Str::random(32);
            $token->active     = true;
            $token->rate_limit = 3000;

            if (!$token->save() ){
                throw new TokenException ('Impossible to create a token');
            }

            # Go to the form with error bag
            return redirect()
                    ->back()
                    ->with([
                        'message' => $token->token
                    ]);
            
        } catch ( TokenException $e ) {

            # Go to the form with error bag
            return redirect()
                    ->back()
                    ->withErrors([
                        'message' => __($e->getMessage())
                    ]);
        }
    }
        
        
        
    /**
     * Remove a token
     *
     * @param  \Illuminate\Http\Request
     * @return bool
     */
    public static function Delete( Request $request )
    {
        try{
            # Check the input fields
            $validator = Validator::make($request->all(), [
                'id' => [
                    'required', 
                    'integer', 
                    'exists:tokens,id'
                ],
            ]);

            if ($validator->fails())
                throw new TokenException ('We could not find your token');

            # Delete the token
            $deleted = Token::where('user_id', Auth::id())
                            ->where('id', $request->input('id'))
                            ->limit(1)
                            ->delete();
                
            if (!$deleted)
                throw new TokenException ('We could not delete your token');
            
            # Go to tokens index
            return redirect()
                    ->back()
                    ->with([
                        'message' => __('Your token has been deleted')
                    ]);
                    
        } catch ( TokenException $e ) {
            
            return redirect()
                    ->back()
                    ->withErrors([
                        'message' => __($e->getMessage())
                    ]);
        }
    }



    /**
     * Switch a token 'active' field
     * 
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function Switch( Request $request )
    {
        try {
            # Check the input fields
            $validator = Validator::make($request->all(), [
                'token' => [
                    'required', 
                    'integer', 
                    Rule::exists('tokens', 'id')->where(function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                ],
            ]);

            if ($validator->fails())
                throw new TokenException ('Some field is malformed');

            # Take the token and switch it
            $code = Token::where('user_id', Auth::id())
                         ->where('id', $request->input('token'))
                         ->first();

            switch ( $code->active ){
                case true:
                    $code->active = false;
                    break;
                case false:
                    if ( !Auth::user()->HasCredits() )
                        throw new TokenException ('You need credits to perform this action');
                    
                    $code->active = true;
                    break;
            }

            # Check code switching
            if ( !$code->save() ){
                throw new TokenException ('Code could not be switched');
            }

            # Go to index page
            return redirect()
                    ->back()
                    ->with([
                        'message' => __('Code switched successfully')
                    ]);;

        } catch ( TokenException $e ) {

            return redirect()
                    ->back()
                    ->withErrors([
                        'message' => __($e->getMessage())
                    ]);
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
            return view('desk.tokens.index', ['tokens' => $tokens]);
            
        } catch ( Exception $e ) {
            Log::error($e);
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
            # Show creation view
            return view('desk.tokens.creation', [
                'abilities' => Token::ALLOWED_ABILITIES
            ]);

        } catch ( Exception $e ) {
            Log::error($e);
            abort(404);
        }
    }
      
      
      
       
}
