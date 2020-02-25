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


Route::group(['namespace' => 'api'], function () {
    Route::get('test', function(){
        $user = \App\User::find(1)->with('permissionGroups.permissions')->get();
        return response()->json([
            $user
        ]);
    });
    Route::resource('users', 'UserController');

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login')->name('auth.login');

        Route::group(['middleware'=> 'auth:api'], function () {
            Route::get('user', 'AuthController@getUser')->name('auth.user');
        });
    });




});

