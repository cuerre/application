<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

use App\Http\Controllers\EncodingController;

class ApiV1Controller extends Controller
{
    /**
     * Encode a string
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function EncodeString ( Request $request ){
        try{
            # Check if data is included (required)
            $validator = Validator::make($request->all(), [
                'data' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data value not found'
                ], 400);
            }

            # Build the image
            $newCode = new EncodingController;
            $qrCode = $newCode->Params($request->all())
                ->BuildImage();

            # Check if the user want to download it
            if( $request->has('download') )
                return $qrCode->GetDownload();

            # Throw the image
            return $qrCode->GetImage();
            
        } catch ( Exception $e ) {

            Log::error($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'We could not create your QR code'
            ], 500);
        }
    }

    /**
     * Decode a picture
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function DecodeFile ( Request $request ){

        try{

            # Try to decode the file
            $qrContent = new DecodingController($request);

            # Check if uploaded file is right
            $qrContent->ValidateFile();
            
            if ( !$qrContent->IsValid() ){
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Input field is malformed'
                ], 400);
            }
            
            # Process the file and give a response
            $content = $qrContent->Process()->GetContent();
            
            if ( empty( $content ) ){
                return response()->json([
                    'status'  => 'error',
                    'data'    => 'No content found'
                ], 400);
            }
                
            # Success decoding the QR
            return response()->json([
                'status'  => 'success',
                'data'    => $content
            ], 200);
            
        }catch( Exception $e ){
            Log::error($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'We could not process your QR code'
            ], 500);
        }
    }
}
