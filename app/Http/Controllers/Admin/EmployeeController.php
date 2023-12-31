<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\EmployeeStoreRequest;
use App\Http\Requests\Admin\Employee\EmployeeUpdateRequest;
use App\Services\Admin\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    protected $service;
    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    public function store(EmployeeStoreRequest $request){
        return $this->service->store($request);
    }

    public function index(Request $request){
        return $this->service->index($request);
    }

    public function show($employee_id){
        return $this->service->show($employee_id);
    }

    public function update($id,EmployeeUpdateRequest $request){
        return $this->service->update($id,$request);
    }

    public function update_logo($id,Request $request){
        $Validator = Validator::make($request->all(),[
            "logo" => "required|mimes:jpg,png,jpeg|max:2048"
        ],[
            "logo.required" => __("employee.you must choose logo image"),
            "logo.mimes" => __("employee.you must choose logo image as jpg,png,jpeg"),
        ]);

        if ($Validator->fails()){
            return Response::errorResponse($Validator->errors());
        }

        return $this->service->updateLogo($id,$request);
    }

    public function resetPassword($id,Request $request){
        $Validation = Validator::make($request->all(),[
            "password" => "required|confirmed|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/"
        ],[
            "password.required" => __("employee.you must enter password"),
            "password.confirmed" => __("employee.password confirmation not match with password"),
            "password.min" => __("employee.you must enter min:8 characters in password"),
        ]);

        if ($Validation->fails()){
            return Response::errorResponse($Validation->errors());
        }

        return $this->service->resetPassword($id,$request);
    }

    public function is_active($id){
        return $this->service->is_active($id);
    }
}
