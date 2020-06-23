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
    Route::get('test', function(){
        $examResults = \App\Models\ExamResult::with('patient','doctor','medicines')->orderBy('updated_at', 'desc')->get();
        return response()->json($examResults);
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login')->name('auth.login');

        Route::group(['middleware'=> 'auth:api'], function () {
            Route::get('user', 'AuthController@getUser')->name('auth.user');
            Route::get('user/permissions', 'AuthController@getUserPermissions')->name('auth.user');
            Route::resource('users', 'UserController')->except(['edit','create']);
            Route::resource('media', 'MediaController')->only(['store','destroy']);
            Route::resource('medicines', 'MedicineController')->only(['index', 'store']);
            Route::resource('examResults', 'ExamResultController')->except(['edit','create']);
            Route::resource('appointments', 'AppointmentController')->except(['edit','create']);
        });
    });
});

