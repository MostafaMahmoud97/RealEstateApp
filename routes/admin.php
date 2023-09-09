<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\AdminAuthController;
use \App\Http\Controllers\Admin\ClientController;
use \App\Http\Controllers\Admin\CommercialActivitiesController;
use \App\Http\Controllers\Admin\RealEstateController;

Route::post('login',[AdminAuthController::class,'login']);
Route::post('logout',[AdminAuthController::class,'logout'])->middleware('auth:admin-api');
Route::post('forgot-password',[AdminAuthController::class,'forgot_password']);
Route::post('change-password',[AdminAuthController::class,'change_password']);

Route::group(['middleware' => 'localRequest'], function()
{
    Route::group(['prefix' => 'client','middleware' => "auth:admin-api"],function (){
        Route::get("type-identities",[ClientController::class,"getTypeIdentities"]);
        Route::post("store",[ClientController::class,"store"]);
        Route::get("index",[ClientController::class,"index"]);
        Route::get("show/{id}",[ClientController::class,"show"]);
        Route::put("update/{id}",[ClientController::class,"update"]);
        Route::put("reset-password/{id}",[ClientController::class,"resetPassword"]);
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
        Route::post("store",[RealEstateController::class,"store"]);
        Route::get("list-all-properties/{user_id}",[RealEstateController::class,"listAllProperties"]);
        Route::get("show-property",[RealEstateController::class,"showProperty"]);
        Route::get("list-units",[RealEstateController::class,"listAllUnits"]);
        Route::get("show-unit/{unit_id}",[RealEstateController::class,"showUnit"]);
    });
});
