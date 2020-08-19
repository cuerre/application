<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/** 
 * DecodingController is a Laravel Controller for decoding QR codes
 * 
 * DecodingController is a Laravel Controller that uses Symfony's 
 * Process library and ZBar Linux library (zbarimg command) to decode
 * QR codes and return the content as a string from a Laravel Request
 * 
 * Example usage:
 * $qrCode = new DecodingController ( Request $request );
 * 
 * # Set parameters
 * $qrCode->AllowedExt(['jpeg', 'png'])->MaxSize(1024);
 * 
 * # Validate and check validation
 * $qrCode->ValidateFile()->IsValid();
 * 
 * # Process and get the content
 * $qrCode->Process()->GetContent();
 * 
 * @package Cuerre
 * @author Alby Hernández
 * @version $Revision: 1.0 $
 * @access private
 * @see http://cuerre.com/documentation
 */
class DecodingController extends Controller
{
    /**
     * Current request
     * 
     * @var Request
     */
    private $request;

    /**
     * Flag for valid file into
     * current request
     * 
     * @var Bool
     */
    private $validFile;

    /**
     * Allowed extensions 
     * for files
     * 
     * @var Array
     */
    private $allowedExt;

    /**
     * Allowed maximun 
     * size for files
     * 
     * @var Integer
     */
    private $maxSize;

    /**
     * Decoded content
     * after processing
     * 
     * @var String
     */
    private $content;

    /**
     * Build a new object setting 
     * its default values
     *
     * @default  data            (default=Cuerre)
     */
    public function __Construct( Request $request )
    {
        # Store the Request
        $this->request = $request;

        # Set default values
        $this->validFile = false;

        $this->allowedExt = [
            'png', 
            'jpeg', 
            'jpg'
        ];

        $this->maxSize = 1024;

        $this->content = '';
    }

    /**
     * Set new extensions array
     * 
     * @param Array $extensions
     */
    public function AllowedExt( array $extensions )
    {
        try{
            $this->allowedExt = $extensions;

            return $this;

        }catch ( Exception $e ){
            Log::error('AllowedExt(): '. $e->getMessage());

            return $this;
        }
    }

    /**
     * Set max file size
     * 
     * @param Int $extensions
     */
    public function MaxSize( int $kb )
    {
        try{
            $this->maxSize = $kb;

            return $this;

        }catch ( Exception $e ){
            Log::error('MaxSize(): '. $e->getMessage());

            return $this;
        }
    }

    /**
     * Check if there is a right
     * file into given request
     * 
     * @return DecodingControler $this
     */
    public function ValidateFile()
    {
        try{
            # Simplify attribute name
            $request = $this->request;

            # Join allowed extensions with glue
            $allowedExt = collect($this->allowedExt)->implode(',');

            # Check if uploaded file is right
            $validator = Validator::make($request->all(), [
                'photo' => [
                    'required',
                    'file',
                    'image',
                    'mimes:'.$allowedExt,
                    'max:'.$this->maxSize
                ],
            ]);

            if( $validator->fails() ){
                $this->validFile = false;
                return $this;
            }

            # The file can be processed
            $this->validFile = true;
            return $this;

        }catch ( Exception $e ){

            Log::error('ValidateFile(): '. $e->getMessage());

            $this->validFile = false;
            return $this;
        }
    }


    /**
     * Check if there is a right
     * file into a Request
     * 
     * @return DecodingController $this
     */
    public function Process( )
    {
        try{
            # Simplify attribute name
            $request = $this->request;

            # Check if the file was validated
            if ( !$this->validFile ){
                throw new Exception('No valid file');
            }

            # Execute decoding 
            $path = $request->photo->path();
            $process = new Process(['zbarimg', '--raw', '-q', $path]);
            $process->run();
            
            # Check looking for failures
            if ( !$process->isSuccessful() ) {
                throw new Exception('File processing failed');
            }

            # Store the content
            $this->content = Str::of($process->getOutput())
                ->trim()
                ->__toString();
            return $this;

        }catch( Exception $e ) {
            Log::error('Process(): '.$e->getMessage());
            $this->content = '';
            return $this;
        }
    }

    /**
     * Return the valifFile attribute
     * 
     * @return Bool
     */
    public function IsValid()
    {
        try{
            # Check content filled
            return $this->validFile;

        }catch( Exception $e ){
            Log::error('GetContent(): '.$e->getMessage());
            
            return false;
        }
    }

    /**
     * Get the code content after processing
     * 
     * @return String
     */
    public function GetContent( )
    {
        try{
            # Check content filled
            if( empty($this->content) ){
                throw new Exception ('There is no content to show');
            }

            return $this->content;

        }catch( Exception $e ){
            Log::error('GetContent(): '.$e->getMessage());
            
            return '';
        }
    }

}
