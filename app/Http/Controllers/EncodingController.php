<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;

/** 
 * EncodingController is a Laravel Controller for encoding data into QR codes
 * 
 * EncodingController is a Laravel Controller that uses Symfony's 
 * Process library and QREncode Linux library (qrencode command) to encode
 * strings into QR codes and return the the image in different formats
 * 
 * Example usage:
 * $qrCode = new EncodingController ();
 * 
 * # Set parameters
 * $qrCode->Params([
 *      'data'       => 'Your string to encode',
 *      'dotsize'    => 3,
 *      'ecc'        => 'L',
 *      'marginsize' => 4,
 *      'dpi'        => 72,
 *      'output'     => 'PNG'
 * ]);
 * 
 * # Build the image into the filesystem
 * $qrCode->BuildImage();
 * 
 * # Get the result
 * $qrCode->GetImagePath();
 * $qrCode->GetBase64();
 * $qrCode->GetImage();
 * $qrCode->GetDownload();
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class EncodingController extends Controller
{
    /**
     * Parameters to build the code
     * 
     * @var Array
     */
    protected $params;

    /**
     * Path to processed image
     * 
     * @var String
     */
    protected $imagePath;

    /**
     * Build a new object setting 
     * its default values
     *
     * @default  data            (default=Cuerre)
     * @default  dotsize         (default=3)
     * @default  ecc             (default=L {LMQH} )
     * @default  marginsize      (default=4 (2 for Micro))
     * @default  dpi             (default=72)
     * @default  output          (default=PNG {PNG,PNG32,EPS,SVG,XPM,ANSI,ANSI256,ASCII,ASCIIi,UTF8,ANSIUTF8})
     */
    public function __Construct()
    {
        $this->params = [
            'data'       => config('app.name'),
            'dotsize'    => 3,
            'ecc'        => 'L',
            'marginsize' => 4,
            'dpi'        => 72,
            'output'     => 'PNG'
        ];
    }

    /**
     * Set new parameters to 
     * build a new code
     * 
     * @param  array    $params
     */
    public function Params ( array $params )
    {
        try {
            $input = collect($params);

            # Set default values
            $defaults = collect($this->params);

            # Set filter rules
            $rules = [
                'data'          => 'string',
                'dotsize'       => 'integer|between:1,5',
                'ecc'           => ['regex:/[L|M|Q|H]{1}/'],
                'marginsize'    => 'integer|between:1,5',
                'dpi'           => 'integer|between:50,100',
                'output'        => ['regex:/^(\bPNG\b)|(\bEPS\b)|(\bSVG\b){1}$/'],
            ];

            # Filter malformed input values
            $filtered = $input->filter(function($item, $key) use ($rules){
                $field = [$key => $item];

                $valid = Validator::make($field, $rules);
                if( !$valid->fails() ){
                    return true;
                }
                return false;
            });
            
            # Change the originals with new values
            $final = $defaults->map(function($item, $key) use ($filtered){
                if ( $filtered->has($key) )
                    return $filtered[$key];
                return $item;
            });

            # Save final collection
            $this->params = $final;

            # Return chainable
            return $this;

        }catch ( Exception $e ){
            Log::error($e);

            return $this;
        }
    }

    /*
     * Generate an image with 
     * defined params
     * 
     * @return EncodingController $this
     */
    public function BuildImage () 
    {
        try {
            $cmd = $this->params;

            # Building a random temporary path
            $tmpPath = storage_path('app/public/'.Str::random(40) );
            
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

            # Failures = store empty path
            if ( !$process->isSuccessful() ) {
                throw new Exception('Image generation failed');
            }

            # No failures = store the path
            $this->imagePath = $tmpPath;

            # Return chainable
            return $this;

        }catch ( Exception $e ){
            Log::error($e);
            $this->imagePath = '';
            return $this;
        }
    }

    /*
     * Get the path to the current
     * generated image
     * 
     * @return string|null
     */
    public function GetImagePath () 
    {
        try {
            if( empty($this->imagePath) ){
                return null;
            }
            return $this->imagePath;

        }catch ( Exception $e ){
            Log::error($e);
            return null;
        }
    }

    /**
     * Return image content as 
     * base64 string
     *
     * @return String
     */
    public function GetBase64 ()
    {
        try{
            # Check if path is right
            if(Str::of($this->imagePath)->trim()->isEmpty()){
                throw new Exception('No image path to convert to base64');
            }

            # Return content as base64
            return base64_encode( file_get_contents($this->imagePath) );

        }catch( Exception $e ){

            Log::error($e);
            return '';
        }
    }

    /**
     * Return image as image
     *
     * @return File
     */
    public function GetImage ()
    {
        try{
            # Check if path is right
            if(Str::of($this->imagePath)->trim()->isEmpty()){
                throw new Exception('No image path to send');
            }

            # Return the image
            return response()->file( $this->imagePath );

        }catch( Exception $e ){

            Log::error($e);
            return '';
        }
    }

    /**
     * Return image as download
     *
     * @return File
     */
    public function GetDownload ()
    {
        try{
            # Check if path is right
            if(Str::of($this->imagePath)->trim()->isEmpty()){
                throw new Exception('No image path to force download');
            }

            # Return the download
            return response()->download( 
                $this->imagePath, 
                Str::random(40) .'.'. $this->params['output']
            )->deleteFileAfterSend();

        }catch( Exception $e ){

            Log::error($e);
            return '';
        }
    }
    
}
