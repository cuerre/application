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

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth', 'password.confirm']);

Route::get('/redirect', 'VisitController@Pipeline');
    





/**
 *
 * Dashboard endpoints
 *
 */
Route::middleware(['auth'])->prefix('dashboard')->group(function () {

    Route::get('/', function () {
        return redirect('/dashboard/codes');
    });

    Route::get('/codes', 'CodesController@ViewIndex');

    Route::get('/codes/creation', 'CodesController@ViewCreation');

    Route::delete('/code', 'CodesController@DeleteOne');

    Route::post('/code', 'CodesController@CreateOne');
    
});




