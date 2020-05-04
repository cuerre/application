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
                ]);
            }

            # Build the image
            $newCode = new EncodingController;
            $qrCode = $newCode->params($request->all())
                ->buildImage();

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
            ]);
        }
    }

    /**
     * Encode a string
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
}
