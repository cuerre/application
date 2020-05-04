<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
            $this->$allowedExt = $extensions;

            return $this;

        }catch ( Exception $e ){
            Log::error('AllowedExt(): '. $e->getMessage());

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

            # Check if 'file' field is present
            if ( !$request->hasFile('photo') ) {
                $this->validFile = false;
                return $this;
            }

            # Check for corrupt file
            if ( !$request->file('photo')->isValid() ) {
                $this->validFile = false;
                return $this;
            }

            # Get file extension (lower case)
            $extension = $request->photo->extension();

            # Check if extension is allowed     
            $allowedExt = collect($this->allowedExt);
            
            if( !$allowedExt->contains($extension) ){
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
