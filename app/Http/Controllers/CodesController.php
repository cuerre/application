<?php

namespace App\Http\Controllers;

use App\StatBrowscap;
use App\Code;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StatsController;

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
                Log::error($e->getMessage());
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
                
                # Retrieve the user
                $userId = Auth::id();
                
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
        
        
        
        /**
        * Remove a code and all associated data
        *
        * @return bool
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
        * @return 
        */
        public static function ViewCreation ()
        {
            try {
                # Show index view
                return view('modules.codes.creation');
                
            } catch ( Exception $e ) {
                Log::error($e->getMessage());

                return redirect('dashboard/codes')
                    ->withErrors([
                        'message' => $e->getMessage()
                    ])
                    ->send();
            }
        }



        /**
        * Get all available stats of a code given
        * as URL param (?code=)
        *
        * @param  Request $request
        * @return Illuminate\Contracts\Support\Renderable
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
                    throw new Exception ('Some field is malformed');

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

                return redirect('dashboard/codes')
                    ->withErrors([
                        'message' => $e->getMessage()
                    ])
                    ->send();
            }
        }
      

}
