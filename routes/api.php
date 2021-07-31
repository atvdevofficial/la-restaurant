<?php

use Illuminate\Http\Request;
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

    Route::group(['prefix' => 'v1'], function () {

        Route::post('/login', 'AuthController@login');

        // Route::get('/verification', 'VerificationController@verifyContactNumber');
        // Route::put('/forgot-password', 'VerificationController@sendCodeToContactNumber');
        // Route::put('/forgot-password/verify-code', 'VerificationController@verifyForgotPasswordCode');
        // Route::put('/forgot-password/change-password', 'VerificationController@forgotPasswordChangePassword');

        Route::apiResource('productCategories', 'ProductCategoryController')
            ->only(['index', 'show']);

        Route::apiResource('products', 'ProductController')
            ->only(['index', 'show']);

        Route::apiResource('deliveryFees', 'DeliveryFeeController')
            ->only(['index', 'show']);

        Route::group(['middleware' => 'auth:api'], function () {

            // Route::post('/logout', 'AuthController@logout');

            // Route::get('/user', function() { return request()->user(); });
            // Route::put('/user/change-password', 'UserController@changePassword');

            Route::get('/notifications', function (Request $request) {
                return $request->user()->notifications;
            });

            Route::get('/dashboard', 'DashboardController')->name('dashboard');

            Route::apiResource('customers', 'CustomerController');

            Route::apiResource('productCategories', 'ProductCategoryController')
                ->only(['store', 'update', 'destroy']);

            Route::apiResource('products', 'ProductController')
                ->only(['store', 'update', 'destroy']);

            Route::apiResource('orders', 'OrderController');

            Route::get('/delivery-fees/calculate', 'DeliveryFeeController@calculate')->name('deliveryFees.calculate');
            Route::apiResource('deliveryFees', 'DeliveryFeeController')
                ->only(['store', 'update', 'destroy']);

            Route::get('/reverse-geocode', function (Request $request) {
                $latitude = $request->latitude ?? null;
                $longitude = $request->longitude ?? null;

                $googleApiKey = env('GOOGLE_API_KEY', null);

                $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$googleApiKey}";
                $response = json_decode(file_get_contents($url), true);
                $address = $response['results'][0]['formatted_address'];
                return $address ?? null;
            });
        });
    });
});
