<?php

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

Route::get('/', function () {
    return view('welcome');
});

//Admin Routes
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    //Admin auth routes
    Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\AdminLoginController@login');

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::post('logout', 'Auth\AdminLoginController@logout')->name('logout');
        Route::get('profile', 'ProfileController@index')->name('profile');
        Route::post('updateProfile/{id}', 'ProfileController@edit')->name('updateProfile');

        /* 
        * Dashboard
        */
        Route::get('/', 'DashboardController@index')->name('home');
        Route::get('dashboard', 'DashboardController@index')->name('home');

        /*users*/
        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('list', 'UserController@index')->name('list');
            Route::get('upgradeRequests', 'UserController@upgradeRequests')->name('upgradeRequest.list');
        });

        /*spots*/
        Route::group(['prefix' => 'spot', 'as' => 'spot.'], function () {
            Route::get('list', 'SpotController@index')->name('list');

            Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
                Route::get('list', 'EventController@index')->name('list');
            });

            Route::group(['prefix' => 'promotion', 'as' => 'promotion.'], function () {
                Route::get('list', 'PromotionController@index')->name('list');
            });

            Route::group(['prefix' => 'competition', 'as' => 'competition.'], function () {
                Route::get('list', 'CompetitionController@index')->name('list');
            });
        });
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
