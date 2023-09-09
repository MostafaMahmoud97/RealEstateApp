<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAuthService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    protected $service;
    public function __construct(AdminAuthService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request){
        return $this->service->login($request);
    }

    public function logout(){
        return $this->service->logout();
    }

    public function forgot_password(Request $request){
        return $this->service->forgot_password($request);
    }

    public function change_password(Request $request){
        return $this->service->change_password($request);
    }
}
