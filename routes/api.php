<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SenderController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ReceiverController;
use App\Http\Controllers\Api\V1\PickupLocationController;
use App\Http\Controllers\NotificationController;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    // Route::post('/facebook-login', [AuthController::class, 'facebookLogin']);
// Route::post('/google-login', [AuthController::class, 'googleLogin']);
// Route::post('/apple-login', [AuthController::class, 'signInWithApple']);
// Route::post('/otprequest', [AuthController::class, 'otpRequest']);
// Route::post('/restore-user', [AuthController::class, 'userRestore']);
// routes/api.php
    Route::post('test-notification', [NotificationController::class, 'sendPushNotification'])->middleware('auth:sanctum');
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::controller(AuthController::class)->group(function () {
            Route::post('/logout', 'logout');
            Route::get('/profile', 'profile');
        });

        Route::controller(SenderController::class)->group(function () {
            Route::put('sender/profile', 'updateProfile');
            Route::get('sender/profile', 'profile');
        });

        Route::controller(OrderController::class)->group(function () {
            Route::get('orders', 'index');            // list sender's orders
            Route::post('orders', 'store');          // create order
            Route::get('orders/{id}', 'show');      // view order
            Route::post('orders/{id}/cancel', 'cancel'); // sender cancels
        });

        Route::apiResource('receivers', ReceiverController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

        Route::controller(PickupLocationController::class)->group(function () {
            Route::get('pickup-locations',  'index');
            Route::post('pickup-locations',  'store');
            Route::put('pickup-locations/{id}', 'update');
            Route::post('pickup-locations/{id}/make-default',  'makeDefault');
            Route::delete('pickup-locations/{id}',  'destroy');
        });
        // Route::post('orders/{orderId}/assign-rider', [RiderController::class, 'assignRider']);
        // Route::post('rider/scan', [RiderScanController::class, 'receiveByScan']);

    });



});

