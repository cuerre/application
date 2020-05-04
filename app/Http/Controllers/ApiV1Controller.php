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
            
            # Check if uploaded file is right
            $validator = Validator::make($request->all(), [
                'photo' => [
                    'required',
                    'file',
                    'image',
                    'mimes:jpeg,png',
                    'max:1024'
                ],
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Input field is malformed'
                ], 400);
            }

            # Try to decode the file
            $qrContent = new DecodingController($request);
            
            $qrContent = $qrContent
                ->ValidateFile()
                ->Process()
                ->GetContent();
            
            if ( empty($qrContent) )
                throw new Exception('Empty content detected. Something failed.');

            # Success decoding the QR
            return response()->json([
                'status'  => 'success',
                'data'    => $qrContent
            ], 200);
            

        }catch( Exception $e ){
            Log::error($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'We could not decode your QR code'
            ], 500);
        }
    }
}
