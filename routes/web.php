<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



/**
 *
 * Web endpoints
 *
 */
Route::get('/', function () {
    return view('modules.codes.show');
});

Auth::routes();



Route::get('/redirect', 'VisitController@Pipeline');
    

Route::get('/pricing', function () {
    return view('pricing');
});

/**
 *
 * Documentation endpoints
 *
 */
Route::prefix('documentation')->group(function () {

    Route::get('/', function () {
        return redirect('/documentation/encode');
    });

    Route::get('/encode', function () {
        return view('modules.documentation.encode');
    });

    Route::get('/decode', function () {
        return view('modules.documentation.decode');
    });
});



/**
 *
 * Dashboard endpoints
 *
 */
Route::middleware(['auth'])->prefix('dashboard')->group(function () {

    Route::get('/', function () {
        return redirect('/dashboard/codes');
    });
    
    Route::prefix('profile')->group(function () {
    
        Route::get('/', 'ProfileController@ViewIndex');
        
        Route::get('/change/name', 'ProfileController@ViewChangeName');
        
        Route::put('/name', 'ProfileController@Update');
        
        Route::get('/change/password', 'ProfileController@ViewChangePassword'); //->middleware(['password.confirm'])
        
        Route::put('/password', 'ProfileController@Update');
        
        Route::get('/deletion', 'ProfileController@ViewDeletion'); //->middleware(['password.confirm'])
        
        Route::delete('/', 'ProfileController@Delete');
    
    });
    
    

    Route::get('/codes', 'CodesController@ViewIndex');

    Route::get('/codes/creation', 'CodesController@ViewCreation');

    Route::get('/codes/stats', 'CodesController@ViewStats');

    Route::delete('/code', 'CodesController@DeleteOne');

    Route::post('/code', 'CodesController@CreateOne');
    
    
    
    Route::get('/support', function () {
        return view('modules.support');
    });


    Route::get('/test', 'OutputController@ViewTest');
        

    
});




