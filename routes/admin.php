<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\AdminAuthController;
use \App\Http\Controllers\Admin\ClientController;
use \App\Http\Controllers\Admin\CommercialActivitiesController;
use \App\Http\Controllers\Admin\RealEstateController;
use \App\Http\Controllers\Admin\EmployeeController;
use \App\Http\Controllers\Admin\DealController;
use \App\Http\Controllers\Admin\NotificationController;
use \App\Http\Controllers\Admin\DashboardController;



Route::group(['middleware' => 'localRequest'], function()
{
    Route::post('login',[AdminAuthController::class,'login']);
    Route::post('logout',[AdminAuthController::class,'logout'])->middleware('auth:admin-api');
    Route::post('forgot-password',[AdminAuthController::class,'forgot_password']);
    Route::post('change-password',[AdminAuthController::class,'change_password']);

    Route::group(['prefix' => 'client','middleware' => "auth:admin-api"],function (){
        Route::get("get-help-data",[ClientController::class,"getHelpData"]);
        Route::post("store",[ClientController::class,"store"]);
        Route::get("index",[ClientController::class,"index"]);
        Route::get("show/{id}",[ClientController::class,"show"]);
        Route::put("update/{id}",[ClientController::class,"update"]);
        Route::put("reset-password/{id}",[ClientController::class,"resetPassword"]);
        Route::put("is-active/{client_id}",[ClientController::class,"is_active"]);
    });

    Route::group(["prefix"=> "commercial-activity","middleware" => "auth:admin-api"],function (){
        Route::get("index/{user_id}",[CommercialActivitiesController::class,"index"]);
        Route::post("store",[CommercialActivitiesController::class,"store"]);
        Route::get("show/{id}",[CommercialActivitiesController::class,"show"]);
        Route::put("update/{id}",[CommercialActivitiesController::class,"update"]);
        Route::delete("delete/{id}",[CommercialActivitiesController::class,"delete"]);
    });

    Route::group(["prefix" => "real-estate","middleware" => "auth:admin-api"],function (){
        Route::get("help-data",[RealEstateController::class,"getHelpData"]);
        Route::get("commercial-activity/{user_id}",[RealEstateController::class,"getCommercialActivity"]);
        Route::get("list-unit-status",[RealEstateController::class,"listAllStatus"]);
        Route::post("store",[RealEstateController::class,"store"]);
        Route::post("list-all-properties",[RealEstateController::class,"listAllProperties"]);
        Route::get("show-property",[RealEstateController::class,"showProperty"]);
        Route::post("list-units",[RealEstateController::class,"listAllUnits"]);
        Route::get("show-unit/{unit_id}",[RealEstateController::class,"showUnit"]);
        Route::get("edit-real-estate/{unit_id}",[RealEstateController::class,"editRealEstate"]);
        Route::put("update-real-estate/{real_estate_id}",[RealEstateController::class,"updateRealEstate"]);
        Route::post("add-new-unit",[RealEstateController::class,"addNewUnit"]);
        Route::put("update-unit/{unit_id}",[RealEstateController::class,"updateUnit"]);
        Route::delete("delete-real-estate/{real_estate_id}",[RealEstateController::class,"deleteRealEstate"]);
        Route::delete("delete-unit/{unit_id}",[RealEstateController::class,"deleteUnit"]);
        Route::put("update-cover-real-estate",[RealEstateController::class,"updateCoverRealEstate"]);
        Route::put("update-media-unit",[RealEstateController::class,"updateMediaUnit"]);
    });

    Route::group(['prefix' => 'employee','middleware' => "auth:admin-api"],function (){
        Route::post("store",[EmployeeController::class,"store"]);
        Route::get("index",[EmployeeController::class,"index"]);
        Route::get("show/{id}",[EmployeeController::class,"show"]);
        Route::put("update/{id}",[EmployeeController::class,"update"]);
        Route::put("update-logo/{id}",[EmployeeController::class,"update_logo"]);
        Route::put("reset-password/{id}",[EmployeeController::class,"resetPassword"]);
        Route::put("is-active/{id}",[EmployeeController::class,"is_active"]);
    });

    Route::group(["prefix" => "deals","middleware" => "auth:admin-api"],function (){
        Route::get("contract-status",[DealController::class,"getContractStatus"]);
        Route::get("/",[DealController::class,"index"]);
        Route::get("show/{deal_id}",[DealController::class,"showDeal"]);
        Route::post("upload-contract",[DealController::class,"uploadContract"]);
    });

    Route::group(["prefix" => "notification","middleware" => "auth:admin-api"],function (){
        Route::get("/",[NotificationController::class,"index"]);
        Route::post("/mark-single-as-read",[NotificationController::class,"markSingleNotiAsRead"]);
        Route::get("/mark-all-as-read",[NotificationController::class,"markAllNotiAsRead"]);
    });

    Route::group(["prefix" => "dashboard","middleware" => "auth:admin-api"],function (){
        Route::get("get-contracts",[DashboardController::class,"getContract"]);
        Route::get("get-users",[DashboardController::class,"getUsers"]);
        Route::get("get-deals",[DashboardController::class,"getDeals"]);
        Route::get("get-units",[DashboardController::class,"getUnits"]);
    });
});
