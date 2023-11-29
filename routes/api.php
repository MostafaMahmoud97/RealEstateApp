<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Client\ClientAuthController;
use \App\Http\Controllers\Client\RealEstateController;
use \App\Http\Controllers\Client\CommercialActivityController;
use \App\Http\Controllers\Client\ManageRequestController;
use \App\Http\Controllers\Client\DealClientController;
use \App\Http\Controllers\Client\SettingController;


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

    Route::group(["prefix" => "setting","middleware" => ["auth:api","verified"]],function (){
        Route::get("all-help-data",[SettingController::class,"get_all_help_data"]);
    });

    Route::group(["prefix" => "user","middleware" => ["auth:api","verified"]],function (){
        Route::get("/",[ClientAuthController::class,"show"]);
        Route::put("update",[ClientAuthController::class,"update"]);
        Route::put("reset-password",[ClientAuthController::class,"resetPassword"]);
    });

    Route::group(["prefix" => "real-estate","middleware" => ["auth:api","verified"]],function (){
        Route::get("help-data",[RealEstateController::class,"getHelpData"]);
        Route::get("commercial-activity",[RealEstateController::class,"getCommercialActivity"]);
        Route::post("store",[RealEstateController::class,"store"]);
        Route::get("list-all-my-properties",[RealEstateController::class,"listAllMyProperties"]);
        Route::get("show-my-property/{unit_id}",[RealEstateController::class,"showMyProperty"]);
        Route::get("edit-real-estate/{unit_id}",[RealEstateController::class,"editRealEstate"]);
        Route::put("update-real-estate/{real_estate_id}",[RealEstateController::class,"updateRealEstate"]);
        Route::put("update-unit/{unit_id}",[RealEstateController::class,"updateUnit"]);
        Route::post("add-new-unit",[RealEstateController::class,"addNewUnit"]);
        Route::delete("delete-real-estate/{real_estate_id}",[RealEstateController::class,"deleteRealEstate"]);
        Route::delete("delete-unit/{unit_id}",[RealEstateController::class,"deleteUnit"]);
        Route::put("update-cover-real-estate",[RealEstateController::class,"updateCoverRealEstate"]);
        Route::put("update-media-unit",[RealEstateController::class,"updateMediaUnit"]);
        Route::get("discover-units",[RealEstateController::class,"DiscoverUnit"]);
        Route::get("home-units",[RealEstateController::class,"HomeUnit"]);
        Route::get("show-unit/{unit_id}",[RealEstateController::class,"showUnit"]);
    });

    Route::group(["prefix" => "commercial-activity","middleware" => ["auth:api","verified"]],function (){
        Route::get("/",[CommercialActivityController::class,"index"]);
        Route::post("store",[CommercialActivityController::class,"store"]);
        Route::get("show/{id}",[CommercialActivityController::class,"show"]);
        Route::put("update/{id}",[CommercialActivityController::class,"update"]);
        Route::delete("delete/{id}",[CommercialActivityController::class,"delete"]);
    });

    Route::group(["prefix" => "request","middleware" => ["auth:api","verified"]],function (){
        Route::get("/click-send-request/{unit_id}",[ManageRequestController::class,"ClickSendRequest"]);
        Route::post("/calc-annual-rent",[ManageRequestController::class,"CalcAnnualRent"]);
        Route::post("/calc-regular-rent-payment",[ManageRequestController::class,"CalcRegularRentPayment"]);
        Route::post("/submit-request",[ManageRequestController::class,"SubmitRequest"]);
        Route::get("/get-count-received-request",[ManageRequestController::class,"GetCountReceivedRequest"]);
        Route::get("/received-request",[ManageRequestController::class,"GetAllReceivedRequest"]);
        Route::get("/show-received-request/{request_id}",[ManageRequestController::class,"ShowReceivedRequest"]);
        Route::post("/change-request-status",[ManageRequestController::class,"ChangeRequestStatus"]);
        Route::get("/list-statues",[ManageRequestController::class,"ListAllRequestStatuses"]);
        Route::get("/sent-requests",[ManageRequestController::class,"GetSentRequests"]);
        Route::get("/show-payment-invoice",[ManageRequestController::class,"showDepositInvoice"]);
        Route::post("/cancel-payment-invoice",[ManageRequestController::class,"CancelPaymentInvoice"]);
        Route::post("/pay-payment-invoice",[ManageRequestController::class,"PayPaymentInvoice"]);
    });

    Route::group(["prefix" => "deals" , "middleware" => ["auth:api","verified"]],function (){
        Route::get("/status-contract",[DealClientController::class,"DealStatusList"]);
        Route::get("/contracts",[DealClientController::class,"index"]);
    });
});
