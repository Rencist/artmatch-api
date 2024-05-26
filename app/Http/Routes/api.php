<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
  
Route::get('hello', function () {
    return response()->json();
});

// User
Route::post('/create_user', [UserController::class, 'createUser']);
Route::post('/login_user', [UserController::class, 'loginUser']);

// Forgot Password
Route::group(['prefix' => '/forgot_password'], function () {
    Route::post('/request', [UserController::class, 'requestForgotPassword']);
    Route::post('/change', [UserController::class, 'changeForgotPassword']);
});

Route::middleware(['iam'])->group(
    function () {
        Route::get('test', function () {
            return response()->json([
                "success" => true,
                "message" => "User Berhasil Mengakses Endpoint Ini"
            ]);
        });

        //User
        Route::get('/me', [UserController::class, 'me']);
        Route::post('/change_password', [UserController::class, 'changePassword']);

        //User
        Route::get('/users', [UserController::class, 'getUserList']);
        Route::delete('/users', [UserController::class, 'deleteUser']);
    }
);
