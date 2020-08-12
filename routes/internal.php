<?php

use Exception;
use App\User;
use Illuminate\Support\Facades\Log;
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



Route::get('/health', function() {
    try{
        # Make a request to the database
        $collection = User::limit(1)->get();

        # Check the result
        if ( $collection->isEmpty() ) {
            throw new Exception('DB query collection is empty');
        }

        # Return the response
        return response()->json([
            'status'    => 'success',
            'message'   => 'query successful'
        ], 200 );

    } catch ( Exception $e ) {
        Log::emergency($e);
        return response()->json([
            'status'    => 'error',
            'message'   => 'query not successful'
        ], 500 );
    }
});
    


Route::any('/{any}', function () {
    return response()->json([
        'status'    => 'error',
        'message'   => 'route not found'
    ], 404 );
})->where('any', '.*');
