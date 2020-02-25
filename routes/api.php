<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('signup', 'AuthController@signup');
        Route::post('login', 'AuthController@login');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');

        Route::group(['prefix' => 'user'], function () {
            Route::post('/upgradeRequest', 'UserController@upgradeRequest');
            Route::post('/upgrade', 'UserController@upgrade');
            Route::post('/updateProfileImage', 'UserController@updateProfileImage');
            Route::get('/profile', 'UserController@show');
        });

        Route::get('category/list', 'SpotController@categories');
        Route::get('business/list', 'SpotController@businessTypes');

        Route::group(['prefix' => 'spot'], function () {
            Route::get('/list', 'SpotController@index');
            Route::post('/create', 'SpotController@store');
            Route::post('/spotUserAccess', 'SpotController@spotUserAccess');
        });

        Route::group(['prefix' => 'event'], function () {
            Route::post('/create', 'EventController@store');
            Route::get('/list', 'EventController@index');
        });
    });

    Route::group(['prefix' => 'upload'], function () {
        Route::post('/image', 'UploadController@uploadImage');
    //    Route::post('/base64Image', 'UploadController@base64UploadRequest');
    });

    Route::get('/spot/spotList', 'SpotController@spotList');
    Route::get('country', 'LocationController@countries');
    Route::match(['get', 'post'], 'state', 'LocationController@states');
    Route::get('/spot/search', 'SpotController@search');
});
