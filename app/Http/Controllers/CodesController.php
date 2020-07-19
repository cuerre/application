<?php

namespace App\Http\Controllers;

use App\Exceptions\CodeException;
use App\Code;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
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
 * Methods:
 * --------
 * self::DeleteOne( int $id ) : bool
 * self::UpdateOrCreateOne( array $fields ) : Model|null
 * self::GetOne( int ) : Illuminate\Support\Collection
 * self::GetPage( int $userId, int $perPage )
 * self::GetImage( int $id, string $format ) : string|null
 * 
 * 
 * 
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
            
        } catch ( CodeException $e ){
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
            
        } catch ( CodeException $e ){
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
            
        } catch ( CodeException $e ){
            Log::error( $e );
            return collect([]);
        }
    }

    /**
     * Get a page of QR codes for a
     * user
     *
     * @param int $userId 
     * @param int $perPage
     * @return \Illuminate\Support\Collection  
     */
    public static function GetPage( int $userId, int $perPage = 25 )
    {
        try {

            # Retrieve all codes for the 'page' given by GET
            $page = Code::where('user_id', $userId)
                         ->paginate($perPage);

            if( $page->isEmpty() ){
                throw new CodeException('no items found');
            }

            # Collect some useful information
            $info = [
                'total'       => $page->total(),
                'perPage'     => $page->perPage(),
                'currentPage' => $page->currentPage(),
                'lastPage'    => $page->lastPage(),
                'currency'    => config('cuerre.billing.currency'),
                'itemPrice'   => config('cuerre.products.codes.price'),
                'totalCost'   => $page->total() * config('cuerre.products.codes.price')
            ];

            # Filter codes to show just some params
            $items = collect([]);
            foreach($page->items() as $item){

                # Put the targets into response
                $targets = [];
                foreach($item->data['targets'] as $key => $target){
                    $targets[$target['system']] = $target['url'];
                }

                $items->push([
                    'id'      => $item->id,
                    'name'    => $item->name,
                    'targets' => $targets,
                    'active'  => $item->active,
                    'created' => Carbon::parse($item->created_at)->toDateTimeString()
                ]);
            }

            # Put all information together
            $data = collect([]);
            foreach($info as $key => $value){
                $data->put($key, $value);
            }
            $data->put('codes', $items );

            # Return it
            return $data;
            
        } catch ( CodeException $e ){
            Log::error($e);
            return collect([]);
        }
    }

    /**
     * Force the download a code according
     * to the request params
     *
     * @param int $id
     * @param string $format
     * @return array [
     *     'path'   => string,
     *     'format' => string
     * ]
     */
    public static function GetImage( int $id, string $format )
    {
        try{
            
            # Set the content of the code
            $codeContent = Str::of('')
                ->append(url('redirect?c='))
                ->append($id);

            # Build and download the code
            $newCode = new EncodingController;
            
            $newImage = $newCode->params([
                'data'   => $codeContent->__toString(),
                'output' => strtoupper($format)
            ])
            ->buildImage()
            ->GetImagePath();

            if( empty($newImage) ){
                return [];
            }

            return [
                'path'   => $newImage,
                'format' => $format
            ];
            
        } catch ( CodeException $e ) {
            Log::error( $e );
            return [];
        }
    }
    
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
            
        } catch ( CodeException $e ) {
            Log::error( $e );
            return '';
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
            # Get the codes collection and paginate them (->paginate(3) ) 
            $page = self::GetPage(Auth::id(), 5);

            //dd($page);

            # Show index view
            return view('modules.codes.index', ['page' => $page]);
            
        } catch ( CodeException $e ) {
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
            
        } catch ( CodeException $e ) {
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
            
        } catch ( CodeException $e ){
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
            
        } catch ( CodeException $e ) {
            Log::error( $e );
            abort(404);
        }
    }
      

}
