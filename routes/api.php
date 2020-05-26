<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['cerbero'])->group(function () {

    # Version 1
    Route::prefix('v1')->group(function () {

        Route::get('/echo', function(){
            return 'echo';
        });

        Route::match(['get', 'post'], '/encode', 'ApiV1Controller@EncodeString');

        Route::post('/decode', 'ApiV1Controller@DecodeFile');
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
