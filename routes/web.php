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



Auth::routes();

Route::get('/redirect', 'VisitController@Pipeline');



/**
 *
 * Website endpoints
 *
 */
Route::get('/', function () {
    return view('web.index');
});

Route::get('/pricing', function () {
    return view('web.pricing');
});

Route::get('/about', function () {
    return view('web.about');
});

Route::get('/sales', function () {
    return view('web.sales');
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
        return view('documentation.faq');
    });

    Route::prefix('api')->group(function () {
        Route::get('/releases', function () {
            return view('documentation.api.releases');
        });

        Route::prefix('v1')->group(function () {
            Route::get('/prologue', function () {
                return view('documentation.api.v1.prologue');
            });

            Route::get('/getencode', function () {
                return view('documentation.api.v1.getencode');
            });

            Route::get('/postdecode', function () {
                return view('documentation.api.v1.postdecode');
            });

            Route::get('/getcodes', function () {
                return view('documentation.api.v1.getcodes');
            });

            Route::get('/getcode', function () {
                return view('documentation.api.v1.getcode');
            });

            Route::get('/getcodeimage', function () {
                return view('documentation.api.v1.getcodeimage');
            });

            Route::get('/postcode', function () {
                return view('documentation.api.v1.postcode');
            });

            Route::get('/putcode', function () {
                return view('documentation.api.v1.putcode');
            });

            Route::get('/deletecode', function () {
                return view('documentation.api.v1.deletecode');
            });
        });
    });

    Route::prefix('contracts')->group(function () {
        Route::get('/terms', function () {
            return view('documentation.contracts.terms');
        });

        Route::get('/privacy', function () {
            return view('documentation.contracts.privacy');
        });
    });
});

/**
 *
 * Desk endpoints
 *
 */
Route::middleware(['auth'])->prefix('desk')->group(function () {

    Route::get('/', function () {
        return redirect('/desk/codes');
    });

    Route::prefix('codes')->group(function () {

        Route::get('/', 'CodesController@ViewIndex');

        Route::get('/download', 'CodesController@ViewDownload')->middleware(['throttle:60,1']);

        Route::get('/creation', 'CodesController@ViewCreation');

        Route::get('/modification', 'CodesController@ViewModification');

        Route::put('/switching', 'CodesController@ViewSwitch');

        Route::get('/stats', 'CodesController@ViewStats');

        Route::delete('/', 'CodesController@ViewDelete');

        Route::post('/', 'CodesController@ViewUpdateOrCreate');
        //Route::post('/', 'CodesController@ViewCreateOne');

        Route::put('/', 'CodesController@ViewUpdateOrCreate');

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
            return view('desk.billing');
        })->name('desk.billing');

        Route::post('payment', 'PaymentController@Payment')->name('payment');

        Route::get('payment/callback', 'PaymentController@Callback')->name('payment.callback');

        Route::get('payment/webhook', 'PaymentController@Webhook')->name('payment.webhook');
    });
    
    Route::get('/support', function () {
        return view('desk.support');
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