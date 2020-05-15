<?php

//use App\User;
//use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EncodingController;
use App\Http\Controllers\DecodingController;
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
Route::get('/test', function (Request $request) {
    //auth()->SumCredits(2);

    //Auth::user()->SumCredits(0.2);

    //return view('test');
    //return new App\Mail\CreditsLow(auth()->user());
});

/**
 *
 * Web endpoints
 *
 */
Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/redirect', 'VisitController@Pipeline');

Route::get('/pricing', function () {
    return view('pricing');
});

Route::get('/about', function () {
    return view('about');
});

/*Route::middleware(['auth'])->prefix('billing')->group(function () {
    Route::get('payment', 'PaymentController@Payment')->name('payment');

    Route::get('cancel', 'PaymentController@cancel')->name('payment.cancel');

    Route::get('payment/success', 'PaymentController@Success')->name('payment.success');
});*/

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
            Route::get('/prologue', function () {
                return view('modules.documentation.api.v1.prologue');
            });

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

    Route::prefix('codes')->group(function () {

        Route::get('/', 'CodesController@ViewIndex');

        Route::get('/download', 'CodesController@GetImageDownload')->middleware(['throttle:60,1']);

        Route::get('/creation', 'CodesController@ViewCreation');

        Route::get('/modification', 'CodesController@ViewModification');

        Route::put('/switching', 'CodesController@SwitchOne');

        Route::get('/stats', 'CodesController@ViewStats');

        Route::delete('/', 'CodesController@DeleteOne');

        Route::post('/', 'CodesController@UpdateOrCreateOne');

        Route::put('/', 'CodesController@UpdateOrCreateOne');

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
    
    });

    Route::prefix('billing')->group(function () {

        Route::get('/', function () {
            return view('modules.billing');
        })->name('dashboard.billing');

        Route::post('payment', 'PaymentController@Payment')->name('payment');

        Route::get('payment/cancel', 'PaymentController@cancel')->name('payment.cancel');

        Route::get('payment/success', 'PaymentController@Success')->name('payment.success');
    });
    
    Route::get('/support', function () {
        return view('modules.support');
    });

    Route::post('/support', 'SupportController@SendRequest');
});



/*
Route::fallback(function () {
    abort (404);
});

Route::any('/', function () {
    abort (404);
});
*/