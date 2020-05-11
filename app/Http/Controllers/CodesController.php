<?php

namespace App\Http\Controllers;

use App\Code;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StatsController;

/** 
 * CodesController is a Laravel Controller for managing App\Code Models and Views
 * 
 * CodesController is a Laravel Controller for managing App\Code data Models 
 * and renderable Views. This means that everything related to url('dashboard/codes')
 * can be found here. This controller tries to keep all methods as static.
 * 
 * Example usage:
 * CodesController::GetAll()
 * CodesController::GetOne( int )
 * CodesController::UpdateOrCreateOne( Request )
 * CodesController::GetEmbededImage( int )
 * CodesController::GetImageDownload( Request )
 * CodesController::ViewIndex()
 * CodesController::ViewCreation()
 * CodesController::ViewModification( Request )
 * CodesController::ViewStats( Request )
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class CodesController extends Controller
{
    /**
    * Get all QR codes for signed in
    * user as a Laravel collection
    *
    * @return \Illuminate\Support\Collection
    */
    public static function GetAll()
    {
        try {
            # We need the user ID
            $userId = Auth::id();
            
            # Retrieve all codes
            $codes = Code::where('user_id', $userId)
                ->get();
            
            # Convert results to collections
            $codes = collect( $codes )
                ->recursive();
            
            return $codes;
            
        } catch ( Exception $e ){

            Log::error($e->getMessage());

            return collect([]);
        }
    }

    /**
    * Get one QR code for signed in user
    *
    * @param  int  $codeId  The code id into database
    * @return  \Illuminate\Support\Collection
    */
    public static function GetOne( int $codeId )
    {
        try {
            # We need the user ID
            $userId = Auth::id();
            
            # Retrieve the code
            $codes = Code::where('user_id', $userId)
                ->where('id', $codeId)
                ->first();
            
            # Convert results to collections
            $codes = collect( $codes )
                ->recursive();
            
            return $codes;
            
        } catch ( Exception $e ){

            Log::error( $e->getMessage() );

            return collect([]);
        }
    }

    /**
    * Get a Base64 representation
    * of the given code
    * 
    * @param  int  $codeId  The code id into database
    * @return String
    */
    public static function GetEmbededImage( int $codeId )
    {
        try{
            # Set the content of the code
            $codeContent = Str::of('')
                ->append(url('redirect?c='))
                ->append($codeId);

            $newCode = new EncodingController;

            $qrCode = $newCode->params([
                'data' => $codeContent->__toString()
            ])
            ->buildImage()
            ->GetBase64();

            return $qrCode;
            
        } catch ( Exception $e ) {

            Log::error($e->getMessage());

            return '';
        }
    }

    /**
    * Force the download a code according
    * to the request params
    *
    * @param Request $request [
    *     ?code=
    *     ?output=   
    * ]
    * @return File
    */
    public static function GetImageDownload( Request $request )
    {
        try{
            # Retrieve the user
            $userId = Auth::id();

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required', 
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                ],
            ]);

            if ($validator->fails())
                throw new Exception ('Some field is malformed');

            # Set the content of the code
            $codeContent = Str::of('')
                ->append(url('redirect?c='))
                ->append($request->input('code'));

            # Build and download the code
            $newCode = new EncodingController;
            
            $qrCode = $newCode->params([
                'data'   => $codeContent->__toString(),
                'output' => $request->input('output')
            ])
            ->buildImage()
            ->GetDownload();

            return $qrCode;
            
        } catch ( Exception $e ) {

            Log::error($e->getMessage());
        }
    }
    
    /**
    * Update a Code if its 'id' is present 
    * on the request or create new one
    *
    * @param  Illuminate\Http\Request
    * @return Illuminate\Http\RedirectResponse
    */
    public static function UpdateOrCreateOne( Request $request )
    {
        try{
            # Retrieve the user
            $userId = Auth::id();
            
            # Check the input fields
            $validator = Validator::make($request->all(), [
                'code'    => [
                    'sometimes',
                    'required',
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                ],
                'name'    => ['required', 'max:100'],
                'targets' => ['required', 'array', 'min:1'],
            ]);
            
            if ($validator->fails())
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('Some field is malformed')
                        ]);

            # Convert targets to a collection
            $targets = collect( $request->input('targets') )->recursive();
            
            # Check targets
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
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('Some target is malformed')
                        ]);
                
            # Check if 'Any' target is set
            $verifyAny = $targets->firstWhere('system', 'any');
            
            if ( is_null($verifyAny) )
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('You must define, at least, the "Any" target')
                        ]);

            $code = Code::updateOrCreate(
                [
                    'id' => $request->input('code'), 
                    'user_id' => $userId
                ],
                [
                    'name' => $request->input('name'), 
                    'data->targets' => $targets->toArray()
                ]
            );

            # Check if saved successfully
            if ( !( $code->wasChanged() || $code->wasRecentlyCreated ) )
                return redirect()
                        ->back()
                        ->withErrors([
                            'message' => __('Sorry, we could not touch the code')
                        ]);

            # Go to the index
            return redirect('dashboard/codes');
            
        } catch ( Exception $e ) {
            Log::error($e->getMessage());

            return dd($e);
            
            # Go to the form with error bag
            return redirect()
                    ->back()
                    ->withErrors([
                        'message' => $e->getMessage() //'Imposible to create your code'
                    ]);
        }
    }
        
    /**
    * Remove a Code and all associated data
    *
    * @param  Illuminate\Http\Request
    * @return \Illuminate\Http\RedirectResponse
    */
    public static function DeleteOne( Request $request )
    {
        try{
            # We need the user ID
            $userId = Auth::id();
                
            # Check input data
            $validator = Validator::make($request->all(), [
                'id' => ['required', 'integer', 'exists:codes'],
            ]);
            
            if ($validator->fails())
                return redirect('dashboard/codes/creation')
                    ->withErrors([
                        'message' => __('Some filed is malformed')
                    ]);
            
            # Delete asked code
            $delete = Code::where('user_id', $userId)
                ->where('id', $request->input('id'))
                ->delete();
                
            if (!$delete)
                return redirect('dashboard/codes/creation')
                    ->withErrors([
                        'message' => __('We could not delete the code')
                    ]);

            return redirect('dashboard/codes');
                    
        } catch ( Exception $e ) {
            Log::error($e->getMessage());
            
            return redirect('dashboard/codes')
                ->withErrors([
                    'message' => __('Impossible to delete your code')
                ]);
        }
    }

    /**
    * Show the index view with codes
    *
    * @param  Request $request
    * @return Illuminate\Contracts\Support\Renderable
    */
    public static function ViewIndex ()
    {
        try {
            # Get the codes collection and paginate them
            $codes = self::GetAll()->paginate(3);

            # Show index view
            return view('modules.codes.index', ['codes' => $codes]);
            
        } catch ( Exception $e ) {
            Log::error($e->getMessage());

            abort(404);
        }
    }
    
    /**
    * Show the creation view for codes
    *
    * @param  Request $request
    * @return Illuminate\Contracts\Support\Renderable
    */
    public static function ViewCreation ()
    {
        try {
            # Show index view
            return view('modules.codes.creation');
            
        } catch ( Exception $e ) {
            Log::error($e->getMessage());

            abort(404);
        }
    }



    /**
    * Get all available stats of a code given
    * as URL param (?code=)
    *
    * @param  Request $request
    * @return Illuminate\Http\RedirectResponse
    */
    public static function ViewStats( Request $request )
    {
        try {
            # We need the user ID and code ID
            $userId = Auth::id();

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required', 
                    'integer',
                    Rule::exists('codes', 'id')->where(function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    }),
                ],
            ]);
            
            if ($validator->fails())
                return redirect('dashboard/codes')
                    ->withErrors([
                        'message' => __('Some field is malformed')
                    ]);

            # Get the stats for that code
            $stats = new StatsController( $request->input('code') );

            # Show index view
            return view('modules.codes.stats', [
                'platforms'     => $stats->GetPlatforms(),
                'browsers'      => $stats->GetBrowsers(),
                'deviceTypes'   => $stats->GetDeviceTypes(),
                'browserTypes'  => $stats->GetBrowserTypes(),
                'lastWeek'      => $stats->GetLastWeek(),
                'lastMonth'     => $stats->GetLastMonth(),
                'lastYear'      => $stats->GetLastYear(),
            ]);
            
        } catch ( Exception $e ){

            Log::error($e->getMessage());

            abort(404);
        }
    }

    /**
    * Show the modification view for a given Code
    *
    * @param  Request  $request
    * @return Illuminate\Contracts\Support\Renderable
    */
    public static function ViewModification ( Request $request )
    {
        try {

            # We need the user ID and code ID
            $userId = Auth::id();

            # Check the input code
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required', 
                    'integer',
                    Rule::exists('codes', 'id')->where(function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    }),
                ],
            ]);

            if ($validator->fails())
                return redirect('dashboard/codes')
                    ->withErrors([
                        'message' => __('Some field is malformed')
                    ]);

            # Show index view
            return view('modules.codes.modification', [
                'code'     => self::GetOne( $request->input('code') )
            ]);
            
        } catch ( Exception $e ) {
            Log::error($e->getMessage());

            abort(404);
        }
    }
      

}
