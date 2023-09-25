<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Client\ClientAuthController;
use \App\Http\Controllers\Client\RealEstateController;


Route::group(['middleware' => 'localRequest'], function()
{
    Route::post('login',[ClientAuthController::class,'login']);
    Route::get("get-help-data",[ClientAuthController::class,"getHelpData"]);
    Route::post('register-client',[ClientAuthController::class,'registerClient']);
    Route::post('resend-verify-token',[ClientAuthController::class,'resendVerifyToken'])->middleware('auth:api');
    Route::post('send-verify-token',[ClientAuthController::class,'sendTokenToVerifyEmail'])->middleware('auth:api');
    Route::post('forgot-password',[ClientAuthController::class,'forgotPassword']);
    Route::post('check-forgot-password-token',[ClientAuthController::class,'sendForgotPasswordToken']);
    Route::post('change-password',[ClientAuthController::class,'change_password']);

    Route::group(["prefix" => "real-estate","middleware" => ["auth:api","verified"]],function (){
        Route::get("help-data",[RealEstateController::class,"getHelpData"]);
        Route::post("store",[RealEstateController::class,"store"]);
        Route::get("list-all-my-properties",[RealEstateController::class,"listAllMyProperties"]);
        Route::get("show-my-property/{unit_id}",[RealEstateController::class,"showMyProperty"]);
        Route::get("edit-real-estate/{unit_id}",[RealEstateController::class,"editRealEstate"]);
        Route::put("update-real-estate/{real_estate_id}",[RealEstateController::class,"updateRealEstate"]);
        Route::delete("delete-real-estate/{real_estate_id}",[RealEstateController::class,"deleteRealEstate"]);
        Route::delete("delete-unit/{unit_id}",[RealEstateController::class,"deleteUnit"]);
        Route::put("update-cover-real-estate",[RealEstateController::class,"updateCoverRealEstate"]);
        Route::put("update-media-unit",[RealEstateController::class,"updateMediaUnit"]);
        Route::get("discover-units",[RealEstateController::class,"DiscoverUnit"]);
    });
});
