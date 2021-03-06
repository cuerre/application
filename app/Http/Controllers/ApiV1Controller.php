<?php

namespace App\Http\Controllers;

use Exception;
use App\Code;
use App\Token;
use App\Exceptions\CodeException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\EncodingController;

/**
 * This controller is the input door
 * for the API v1. All the API routes 
 * have a method here that validate the 
 * parameters before executing actions
 * on the real controllers. This controller 
 * take the returned value of other classes and
 * return a valid JSON response for the user
 * 
 * Methods:
 * --------
 * self::EncodeString()
 * self::DecodeFile()
 * self::GetCodes()
 * self::GetCode()
 * self::GetCodeImage()
 * self::DeleteCode()
 * self::PostCode()
 * self::PutCode()
 * 
 */
class ApiV1Controller extends Controller
{
    /**
     * Encode a string
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function EncodeString ( Request $request )
    {
        try{
            # Check if data is included (required)
            $validator = Validator::make($request->all(), [
                'data' => ['required', 'string', 'max:255'],
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

            Log::error($e);

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
    public static function DecodeFile ( Request $request )
    {
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

    /**
     * Get a code from the system
     * and render all information and stats 
     * into a JSON message
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public static function GetCodes ( Request $request )
    {
        try{

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'page' => ['sometimes', 'required', 'integer'],
            ]);

            if ($validator->fails()) {
                throw new CodeException('page malformed');
            }

            $token = Token::where('token', $request->input('apikey'))->first();

            # Get a page of codes
            $got = CodesController::GetPage($token->user_id);

            if( $got->isEmpty() ){
                throw new CodeException('the list is empty');
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'provided',
                'data'    => $got
            ], 200);
            
        } catch ( CodeException $e ) {

            Log::error($e);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get a code from the system
     * and render all information and stats 
     * into a JSON message
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public static function GetCode ( Request $request )
    {
        try{

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'id' => [
                    'required', 
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) use ($request){
                        $token = Token::where('token', $request->input('apikey'))->first();

                        # Code owner must be the same as token owner
                        $query->where('user_id', $token->user_id);
                    })
                ],
            ]);
    
            if ($validator->fails()) {
                throw new CodeException('code not found');
            }

            # Delete the image
            $got = CodesController::GetOne($request->input('id'));
            if( empty($got) ){
                throw new CodeException('impossible to get the code');
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'provided',
                'data'    => $got
            ], 200);
            
        } catch ( CodeException $e ) {

            Log::error($e);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Download a code as image
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public static function GetCodeImage ( Request $request )
    {
        try{
            
            # Check the input fields
            $validator = Validator::make($request->all(), [
                'id' => [
                    'required', 
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) use ($request){
                        $token = Token::where('token', $request->input('apikey'))->first();

                        # Code owner must be the same as token owner
                        $query->where('user_id', $token->user_id);
                    })
                    
                ],
                'format' => [
                    'required',
                    Rule::in(['svg', 'png', 'eps']),
                ],
            ]);
            
            if ($validator->fails())
                throw new CodeException ('field malformed');

            # Create the new image
            $newImage = CodesController::GetImage( 
                $request->input('id'), 
                $request->input('format') 
            );

            if( empty($newImage) ){
                throw new CodeException('impossible to build the image');
            }

            # Craft the code public URL
            $publicPath = url('storage/'.basename($newImage['path']));

            # Give the response to the user
            return response()->json([
                'status'  => 'success',
                'data'    => [
                    'image'  => $publicPath,
                    'format' => $request->input('format')
                ]
            ], 200, [], JSON_UNESCAPED_SLASHES);
            
        }catch( CodeException $e ){
            Log::error($e);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Delete a code from the system
     * and render a JSON message
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public static function DeleteCode ( Request $request)
    {
        try{

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'id' => [
                    'required', 
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) use ($request){
                        $token = Token::where('token', $request->input('apikey'))->first();

                        # Code owner must be the same as token owner
                        $query->where('user_id', $token->user_id);
                    })
                ],
            ]);
    
            if ($validator->fails()) {
                throw new CodeException('code not found');
            }

            # Delete the image
            $deleted = CodesController::DeleteOne($request->input('id'));
            if( !$deleted ){
                throw new CodeException('impossible to delete the code');
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'code deleted'
            ], 200);
            
        } catch ( CodeException $e ) {

            Log::error($e);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Check input fields and 
     * create a brand new code
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public static function PostCode ( Request $request )
    {
        try{
            $token = Token::where('token', $request->input('apikey'))->first();

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'name'        => ['required', 'filled', 'string'],
                'targets'     => ['required', 'filled'],
                'targets.any' => ['required_with:targets'],
                'targets.*'   => ['string', 'url']
            ]);
    
            if ( $validator->fails() ) {
                throw new CodeException($validator->errors()->first());
            }

            # Check allowed targets
            if ( $request->has('targets') ) {
                foreach ( $request->input('targets') as $key => $target ){
                    if( !in_array($key, Code::ALLOWED_TARGETS) ){
                        throw new CodeException('The targets.'.$key.' field is not allowed');
                    }
                }                
            }

            # Filter some things before passing it            
            $fields = $validator->validated();
            $fields['user_id'] = $token->user_id;
            $fields['active']  = false;
            
            # Create the code
            $created = CodesController::UpdateOrCreateOne($fields);
            if( empty($created) ){
                throw new CodeException('Impossible to create the code');
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'created',
                'data'    => [
                    'id'      => $created->id,
                    'name'    => $created->name,
                    'targets' => $created->data['targets'],
                    'active'  => $created->active
                ]
            ], 200);
            
        } catch ( CodeException $e ) {

            Log::error($e);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Check input fields and 
     * change code parameters
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public static function PutCode ( Request $request )
    {
        try{

            $token = Token::where('token', $request->input('apikey'))->first();

            # Check the input fields
            $validator = Validator::make($request->all(), [
                'id' => [
                    'required', 
                    'integer', 
                    Rule::exists('codes', 'id')->where(function ($query) use ($token){
                        
                        # Code owner must be the same as token owner
                        $query->where('user_id', $token->user_id);
                    })
                ],
                'name'        => ['sometimes', 'required', 'filled', 'string'],
                'targets'     => ['sometimes', 'required', 'filled'],
                'targets.any' => ['required_with:targets'],
                'targets.*'   => ['string', 'url'],
                'active'      => ['sometimes', 'required', 'bool'],
            ]);
    
            if ( $validator->fails() ) {
                throw new CodeException($validator->errors()->first());
            }

            # Check allowed targets
            if ( $request->has('targets') ) {
                foreach ( $request->input('targets') as $key => $target ){
                    if( !in_array($key, Code::ALLOWED_TARGETS) ){
                        throw new CodeException('The targets.'.$key.' field is not allowed');
                    }
                }                
            }

            # Update the image
            $fields = $validator->validated();

            $updated = CodesController::UpdateOrCreateOne($fields);
            if( empty($updated) ){
                throw new CodeException('Impossible to update the code');
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'updated',
                'data'    => [
                    'id'      => $updated->id,
                    'name'    => $updated->name,
                    'targets' => $updated->data['targets'],
                    'active'  => $updated->active
                ]
            ], 200);
            
        } catch ( CodeException $e ) {

            Log::error($e);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    
    
}
