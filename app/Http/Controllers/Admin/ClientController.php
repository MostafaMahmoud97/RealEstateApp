<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\ClientStoreRequest;
use App\Http\Requests\Admin\Client\ClientUpdateRequest;
use App\Services\Admin\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    protected $service;
    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function getTypeIdentities(){
        return $this->service->getTypeIdentities();
    }

    public function store(ClientStoreRequest $request){
        return $this->service->store($request);
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function update($id,ClientUpdateRequest $request){
        return $this->service->update($id,$request);
    }

    public function resetPassword($id,Request $request){
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

        return $this->service->resetPassword($id,$request);
    }

    public function is_active($client_id){
        return $this->service->is_active($client_id);
    }
}
