<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
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
});

//
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::prefix('v1')->group(function () {

            Route::post('/logout', 'logout');
            Route::get('/profile', 'profile');
        });

    });
});
