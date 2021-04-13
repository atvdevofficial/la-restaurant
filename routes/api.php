<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'forceJsonResponse'], function () {

    Route::group(['prefix' => 'v1'], function() {

        Route::post('/login', 'AuthController@login');

        Route::get('/verification', 'VerificationController@verifyContactNumber');
        Route::put('/forgot-password', 'VerificationController@sendCodeToContactNumber');
        Route::put('/forgot-password/verify-code', 'VerificationController@verifyForgotPasswordCode');
        Route::put('/forgot-password/change-password', 'VerificationController@forgotPasswordChangePassword');

        Route::group(['middleware' => 'auth:api'], function() {

            Route::post('/logout', 'AuthController@logout');

            Route::get('/user', function() { return request()->user(); });
            Route::put('/user/change-password', 'UserController@changePassword');
        });
    });
});
