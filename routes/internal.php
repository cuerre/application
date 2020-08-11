<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Internal Routes
|--------------------------------------------------------------------------
|
| Here is where you can register internal routes for performing a health
| check and more actions like that.
|
*/



Route::get('/health', function(){
    /*
    return response()->json([
        'status'    => 'error',
        'message'   => 'route not found'
    ], 404 );
    */
});
    


Route::any('/{any}', function () {
    
    return response()->json([
        'status'    => 'error',
        'message'   => 'route not found'
    ], 404 );

})->where('any', '.*');
