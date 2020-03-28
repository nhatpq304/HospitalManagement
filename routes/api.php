<?php

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


Route::group(['namespace' => 'Api'], function () {
    Route::post('/test', function( Illuminate\Http\Request $request ){
//        return $request;
        \Illuminate\Support\Facades\Storage::disk('s3')->put('images', $request->image, 'public');;
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login')->name('auth.login');

        Route::group(['middleware'=> 'auth:api'], function () {
            Route::get('user', 'AuthController@getUser')->name('auth.user');
            Route::resource('users', 'UserController');
        });
    });




});

