<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;

class EncodingController extends Controller
{
    /*
     *
     * @param  array    $params
     *      data                (default=Cuerre)
     *      dotsize             (default=3)
     *      ecc                 (default=L {LMQH} )
     *      marginsize          (default=4 (2 for Micro))
     *      dpi                 (default=72)
     *      output              (default=PNG {PNG,PNG32,EPS,SVG,XPM,ANSI,ANSI256,ASCII,ASCIIi,UTF8,ANSIUTF8})
     */
    public static function filterParams ( array $params )
    {
        try {
            $input = collect($params);

            # Set default values
            $defaults = collect([
                'data'       => config('app.name'),
                'dotsize'    => 5,
                'ecc'        => 'L',
                'marginsize' => 4,
                'dpi'        => 72,
                'output'     => 'PNG'
            ]);

            # Set filter rules
            $rules = [
                'data'          => 'string',
                'dotsize'       => 'integer|between:1,5',
                'ecc'           => ['regex:/[L|M|Q|H]{1}/'],
                'marginsize'    => 'integer|between:1,5',
                'dpi'           => 'integer|between:50,100',
                'output'        => ['regex:/[PNG|EPS|SVG]{1}/'],
            ];

            # Filter malformed input values
            $filtered = $input->filter(function($item, $key) use ($rules){
                $field = [$key => $item];

                $valid = Validator::make($field, $rules);
                if( !$valid->fails() )
                    return true;
                return false;
            });
            
            # Change the originals with new values
            $final = $defaults->map(function($item, $key) use ($filtered){
                if ( $filtered->has($key) )
                    return $filtered[$key];
                return $item;
            });

            # return final collection
            return $final;
        }catch ( Exception $e ){

            Log::error($e->getMessage());
            return $defaults;
        }
    }



    /*
     * Generate an image with requested params
     * 
     * @return  String  Path/to/the/image
     */
    public static function BuildImage ( array $params = []) 
    {
        try {
            $cmd = self::filterParams($params);

            # Building a random temporary path
            $tmpPath = '/tmp/' . Str::random(40);
            
            # Execute decoding
            $cmd = [
                'qrencode', 
                '-s', $cmd['dotsize'],
                '-l', $cmd['ecc'],
                '-m', $cmd['marginsize'],
                '-d', $cmd['dpi'],
                '-t', $cmd['output'],
                '-o', $tmpPath,
                $cmd['data']
            ];
            
            $process = new Process($cmd);
            $process->run();

            # No failures = return the path
            if ( !$process->isSuccessful() ) {
                return '';
            }

            # Failures = return emptyness
            return $tmpPath;

        }catch ( Exception $e ){
            Log::error($e->getMessage());
            return '';
        }

    }



    /**
     * Convert a string into a QR image
     *
     * @param  Array  $params
     * @return String
     */
    public static function GetImageBase64 ( array $params = [] )
    {
        try{
            # Try to generate an image
            $imagePath = self::BuildImage( $params );
            
            # Check if path is right
            if(Str::of($imagePath)->trim()->isEmpty()){
                return '';
            }

            return base64_encode( file_get_contents($imagePath) );
        }catch( Exception $e ){
            
            Log::error($e->getMessage());
            return '';
        }
    }


    /*
		if ($request->has('download')) {
            return response()
                ->download( $tmpPath, Str::random(40) .'.'. $request->input('output') );
        }
        */
        
		# Return QR image
		//return response()->file( $tmpPath );
    
}
