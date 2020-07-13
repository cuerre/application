<?php

namespace App\Http\Controllers;

use Exception;
use App\Exceptions\CodeException;
use App\Code;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
 * self::DeleteOne( int $id ) : bool
 * self::UpdateOrCreateOne( array $fields ) : Model|null
 * self::GetOne( int ) : Illuminate\Support\Collection
 * 
 * self::GetAll()
 * self::GetEmbededImage( int )
 * self::GetImageDownload( Request )
 * self::SwitchOne( int )
 * self::ViewIndex()
 * self::ViewCreation()
 * self::ViewModification( Request )
 * self::ViewStats( Request )
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
    * Delete a code from the system
    *
    * @param int $id
    * @return bool
    */
    public static function DeleteOne( int $id ) : bool
    {
        try {
            # Get the code model from DB
            $code = Code::find($id);

            if ( empty($code) ){
                throw new CodeException('code not found');
            }

            if( !$code->delete() ){
                throw new CodeException('not possible to delete the code');
            }
           
            return true;
            
        } catch ( Exception $e ){
            Log::error($e);
            return false;
        }
    }

    /**
    * Update or create a 
    * code into the system
    *
    * @param array $fields
    * @return Model|null
    */
    public static function UpdateOrCreateOne( array $fields )
    {
        try {

            # Check the input fields
            $validator = Validator::make($fields, [
                'id'          => ['sometimes', 'required', 'integer'],
                'user_id'     => ['sometimes', 'required', 'integer'],
                'name'        => ['sometimes', 'required', 'filled', 'string'],
                'targets'     => ['sometimes', 'required', 'filled'],
                'targets.any' => ['required_with:targets'],
                'targets.*'   => ['string','url'],
                'active'      => ['sometimes', 'required', 'bool'],
            ]);

            if ( $validator->fails() ) {
                throw new CodeException($validator->errors()->first());
            }

            # Turn it into collection for having some methods
            $fields = collect($validator->validated())->recursive();

            # Get the model from DB
            if( $fields->has('id') ){
                $code = Code::find($fields['id']);
                if ( empty($code) ){
                    throw new CodeException('Code not found');
                }
            }else{
                $code = new Code;
            }

            # Set new values
            if( $fields->has('user_id') ){
                $code->user_id = $fields['user_id'];
            }

            if( $fields->has('active') ){
                $code->active = $fields['active'];
            }

            if( $fields->has('name') ){
                $code->name = $fields['name'];
            }

            # Check allowed targets
            if( $fields->has('targets') ){
                $newTargets = collect([]);
                foreach ( $fields['targets'] as $key => $target ){
                    if( !in_array($key, Code::ALLOWED_TARGETS) ){
                        throw new CodeException('The targets.'.$key.' field is not allowed');
                    }

                    $newTargets->push([
                        'url'    => $target,
                        'system' => $key
                    ]);
                }  
                $data = $code->data;
                $data['targets'] = $newTargets->toArray();
                $code->data = $data;
            }

            if( !$code->save() ){
                throw new CodeException('Impossible to update the code');
            }
           
            return $code;
            
        } catch ( Exception $e ){
            Log::error($e);
            return null;
        }
    }

    /**
    * Get a code from the system
    * and return all information 
    * about it
    *
    * @param int $id
    * @return Illuminate\Support\Collection  
    */
    public static function GetOne( int $id )
    {
        try {
            
            # Get the code model from DB
            $code = Code::find($id);

            if ( empty($code) ){
                throw new CodeException('code not found');
            }

            # Set a placeholder for the response
            $data = collect([]);

            # Push the id into response
            $data->put('id', $code->id);

            # Push the name into response
            $data->put('name', $code->name);

            # Check targets
            if( empty($code->data['targets']) ){
                throw new CodeException('code not found');
            }

            # Put the targets into response
            $targets = [];
            foreach($code->data['targets'] as $key => $target){
                $targets[$target['system']] = $target['url'];
            }
            $data->put('targets', $targets);

            # Put the stats into response
            $stats = new StatsController($id);
            $data->put('stats', [
                'sample'        => $stats->GetSampleMax(),
                'platforms'     => $stats->GetPlatforms(),
                'browsers'      => $stats->GetBrowsers(),
                'deviceTypes'   => $stats->GetDeviceTypes(),
                'browserTypes'  => $stats->GetBrowserTypes(),
                'lastWeek'      => $stats->GetLastWeek(),
                'lastMonth'     => $stats->GetLastMonth(),
                'lastYear'      => $stats->GetLastYear(),
            ]);
           
            return $data;
            
        } catch ( Exception $e ){
            Log::error( $e );
            return collect([]);
        }
    }

    /**
    * Get all QR codes for signed in
    * user as a Laravel collection
    *
    * @return \Illuminate\Support\Collection  
    */
    /*
    public static function GetAll()
    {
        try {

            # Retrieve all codes
            $codes = Code::where('user_id', Auth::id())
                         ->get();
            
            # Convert results to collections
            return collect( $codes )
                 ->recursive();
            
        } catch ( Exception $e ){
            Log::error($e);
            return collect([]);
        }
    }
    */

    /**
    * Get a Base64 representation
    * of the given code
    * 
    * @param  int  $codeId  The code id into database
    * @return string
    */
    public static function GetEmbededImage( int $codeId )
    {
        try{
            # Set the content of the code
            $codeContent = Str::of('')
                ->append(url('redirect?c='))
                ->append($codeId);

            $newCode = new EncodingController;

            return $newCode->params([
                'data' => $codeContent->__toString()
            ])
            ->buildImage()
            ->GetBase64();
            
        } catch ( Exception $e ) {
            Log::error( $e );
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
            # Check the input fields
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required', 
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                ],
            ]);

            if ($validator->fails())
                throw new CodeException ('Some field is malformed');

            # Set the content of the code
            $codeContent = Str::of('')
                ->append(url('redirect?c='))
                ->append($request->input('code'));

            # Build and download the code
            $newCode = new EncodingController;
            
            return $newCode->params([
                'data'   => $codeContent->__toString(),
                'output' => $request->input('output')
            ])
            ->buildImage()
            ->GetDownload();
            
        } catch ( CodeException $e ) {
            Log::error( $e );
        }
    }

    /**
     * Set a code as 'active'
     * 
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function SwitchOne( Request $request )
    {
        try {

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required', 
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) {
                        $query->where('user_id', Auth::id());
                    })
                ],
            ]);

            if ($validator->fails())
                throw new CodeException ('Some field is malformed');

            # Take the code and switch it
            $code = Code::where('user_id', Auth::id())
                        ->where('id', $request->input('code'))
                        ->first();

            switch ( $code->active ){
                case true:
                    $code->active = false;
                    break;
                case false:
                    if ( !Auth::user()->HasCredits() )
                        throw new CodeException ('You need credits to perform this action');
                    
                    $code->active = true;
                    break;
            }

            # Check code switching
            if ( !$code->save() ){
                throw new CodeException ('Code could not be switched');
            }

            # Go to index page
            return redirect()
                    ->back()
                    ->with([
                        'message' => __('Code switched successfully')
                    ]);;

        } catch ( CodeException $e ) {
            Log::error( $e );

            return redirect()
                    ->back()
                    ->withErrors([
                        'message' => __($e->getMessage())
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
            Log::error( $e );
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
            Log::error( $e );
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

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required', 
                    'integer',
                    Rule::exists('codes', 'id')->where(function ($query) {
                        $query->where('user_id', Auth::id());
                    }),
                ],
            ]);
            
            if ($validator->fails())
                throw new CodeException ('Some field is malformed');

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
            Log::error( $e );
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

            # Check the input code
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required', 
                    'integer',
                    Rule::exists('codes', 'id')->where(function ($query) {
                        $query->where('user_id', Auth::id());
                    }),
                ],
            ]);

            if ($validator->fails())
                throw new CodeException ('Some field is malformed');

            # Show index view
            return view('modules.codes.modification', [
                'code' => self::GetOne( $request->input('code') )
            ]);
            
        } catch ( Exception $e ) {
            Log::error( $e );
            abort(404);
        }
    }
      

}
