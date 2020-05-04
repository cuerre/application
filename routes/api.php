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
            return 'echo';
        });

        Route::match(['get', 'post'], '/encode', 'ApiV1Controller@EncodeString');

        //Route::post('/decode', 'DecodingController@DecodeFile');
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
