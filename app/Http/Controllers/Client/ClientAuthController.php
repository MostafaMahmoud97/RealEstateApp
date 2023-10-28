<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\ClientStoreRequest;
use App\Http\Requests\Client\User\UpdateUserRequest;
use App\Services\Client\ClientAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ClientAuthController extends Controller
{
    protected $service;
    public function __construct(ClientAuthService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request){
        return $this->service->login($request);
    }

    public function getHelpData(){
        return $this->service->getHelpData();
    }

    public function registerClient(ClientStoreRequest $request){
        return $this->service->registerClient($request);
    }

    public function show(){
        return $this->service->show();
    }

    public function update(UpdateUserRequest $request){
        return $this->service->update($request);
    }

    public function resetPassword(Request $request){
        $Validation = Validator::make($request->all(),[
            "password" => "required|confirmed|min:8"
        ],[
            "password.required" => __("client.you must enter password"),
            "password.confirmed" => __("client.password confirmation not match with password"),
            "password.min" => __("client.you must enter min:8 characters in password"),
        ]);

        if ($Validation->fails()){
            return Response::errorResponse($Validation->errors());
        }

        return $this->service->resetPassword($request);
    }

    public function resendVerifyToken(){
        return $this->service->resendVerifyToken();
    }

    public function sendTokenToVerifyEmail(Request $request){
        return $this->service->sendTokenToVerifyEmail($request);
    }

    public function forgotPassword(Request $request){
        return $this->service->forgotPassword($request);
    }

    public function sendForgotPasswordToken(Request $request){
        return $this->service->sendForgotPasswordToken($request);
    }

    public function change_password(Request $request){
        return $this->service->change_password($request);
    }
}
