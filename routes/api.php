<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//auth:sanctum
Route::middleware(['auth:sanctum','throttle:60,1'])->group(function () {

    # Version 1
    Route::prefix('v1')->group(function () {

        Route::get('/echo', function(){

            //$response = Http::withToken('4wH5o3soQZog999BYRHzdPBoayqtFzqDrzc7MeY62JW04BtsyxtFyj8xOsDHnPLRl6hgWlHzdcvZnOqD')
            //->get('http://api.cuerre.com/v1/encode');

            //$response = Http::get('http://api.cuerre.com');

            //return $response;
        });

        Route::post('/decode', 'DecodingController@DecodeFile');

        Route::get('/encode', 'EncodingController@EncodeString');
    });

    # Version 2
    Route::prefix('v2')->group(function () {

        Route::get('/echo', function(){
            return 'echo';
        });
    });
    

});



Route::any('/{any}', function () {
    
    return response()->json([
        'status'    => 'error',
        'message'   => 'route not found'
    ], 404 );

})->where('any', '.*');
