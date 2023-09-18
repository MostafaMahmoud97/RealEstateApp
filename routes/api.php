<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Client\ClientAuthController;


Route::group(['middleware' => 'localRequest'], function()
{
    Route::post('login',[ClientAuthController::class,'login']);
    Route::get('type-identities',[ClientAuthController::class,'getTypeIdentities']);
    Route::post('register-client',[ClientAuthController::class,'registerClient']);
    Route::post('resend-verify-token',[ClientAuthController::class,'resendVerifyToken'])->middleware('auth:api');
    Route::post('send-verify-token',[ClientAuthController::class,'sendTokenToVerifyEmail'])->middleware('auth:api');
});
