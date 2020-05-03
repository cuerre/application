<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EncodingController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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


Route::get('/he', function (Request $request) {

    
});


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
        return redirect('/documentation/faq');
    });

    Route::get('/faq', function () {
        return view('modules.documentation.faq');
    });

    Route::prefix('api')->group(function () {
        Route::get('/releases', function () {
            return view('modules.documentation.api.releases');
        });

        Route::prefix('v1')->group(function () {
            Route::get('/encode', function () {
                return view('modules.documentation.api.v1.encode');
            });

            Route::get('/decode', function () {
                return view('modules.documentation.api.v1.decode');
            });
        });
    });

    
    Route::prefix('contracts')->group(function () {
        Route::get('/terms', function () {
            return view('modules.documentation.contracts.terms');
        });

        Route::get('/privacy', function () {
            return view('modules.documentation.contracts.privacy');
        });
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

    Route::prefix('tokens')->group(function () {
    
        Route::get('/', 'TokensController@ViewIndex');

        Route::get('/creation', 'TokensController@ViewCreation');

        Route::post('/', 'TokensController@Create');

        Route::delete('/', 'TokensController@Delete');
        
        //Route::get('/change/name', 'ProfileController@ViewChangeName');
        
        //Route::put('/name', 'ProfileController@Update');
        
        //Route::get('/change/password', 'ProfileController@ViewChangePassword'); //->middleware(['password.confirm'])
        
        //Route::put('/password', 'ProfileController@Update');
        
        //Route::get('/deletion', 'ProfileController@ViewDeletion'); //->middleware(['password.confirm'])
        
        //Route::delete('/', 'ProfileController@Delete');
    
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




