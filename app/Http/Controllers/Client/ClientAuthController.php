<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\ClientStoreRequest;
use App\Services\Client\ClientAuthService;
use Illuminate\Http\Request;

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

    public function getTypeIdentities(){
        return $this->service->getTypeIdentities();
    }

    public function registerClient(ClientStoreRequest $request){
        return $this->service->registerClient($request);
    }

    public function resendVerifyToken(){
        return $this->service->resendVerifyToken();
    }

    public function sendTokenToVerifyEmail(Request $request){
        return $this->service->sendTokenToVerifyEmail($request);
    }
}
