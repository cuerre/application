<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/sales', function () {
    return view('sales');
});

Route::post('/sales', 'ContactController@SendSalesRequest');



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

            Route::get('/getencode', function () {
                return view('modules.documentation.api.v1.getencode');
            });

            Route::get('/postdecode', function () {
                return view('modules.documentation.api.v1.postdecode');
            });

            Route::get('/getcodes', function () {
                return view('modules.documentation.api.v1.getcodes');
            });

            Route::get('/getcode', function () {
                return view('modules.documentation.api.v1.getcode');
            });

            Route::get('/getcodeimage', function () {
                return view('modules.documentation.api.v1.getcodeimage');
            });

            Route::get('/postcode', function () {
                return view('modules.documentation.api.v1.postcode');
            });

            Route::get('/putcode', function () {
                return view('modules.documentation.api.v1.putcode');
            });

            Route::get('/deletecode', function () {
                return view('modules.documentation.api.v1.deletecode');
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

        Route::put('/switching', 'TokensController@Switch');
    
    });

    Route::prefix('billing')->group(function () {

        Route::get('/', function () {
            return view('modules.billing');
        })->name('dashboard.billing');

        Route::post('payment', 'PaymentController@Payment')->name('payment');

        Route::get('payment/callback', 'PaymentController@Callback')->name('payment.callback');

        Route::get('payment/webhook', 'PaymentController@Webhook')->name('payment.webhook');
    });
    
    Route::get('/support', function () {
        return view('modules.support');
    });

    Route::post('/support', 'ContactController@SendSupportRequest');
});



/*
Route::fallback(function () {
    abort (404);
});

Route::any('/', function () {
    abort (404);
});
*/