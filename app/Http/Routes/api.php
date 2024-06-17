<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KaryaController;

Route::get('hello', function () {
    return response()->json();
});

// User
Route::post('/user', [UserController::class, 'createUser']);
Route::post('/user/login', [UserController::class, 'loginUser']);

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
        Route::patch('/user', [UserController::class, 'updateUser']);
        Route::get('/user/me', [UserController::class, 'me']);
        // Route::post('/user/change_password', [UserController::class, 'changePassword']);
        // Route::get('/users', [UserController::class, 'getUserList']);
        // Route::delete('/users', [UserController::class, 'deleteUser']);

        //Tag
        Route::post('/tags', [TagController::class, 'createTag']);
        Route::get('/tags', [TagController::class, 'getAllTag']);

        //Karya
        Route::post('/karya', [KaryaController::class, 'createKarya']);
        Route::get('/karya', [KaryaController::class, 'getAllKarya']);
        Route::get('/karya/{id}', [KaryaController::class, 'getDetailKarya']);
        Route::delete('/karya/{id}', [KaryaController::class, 'deleteKarya']);
        Route::get('/model', [KaryaController::class, 'getModel']);
    }
);
