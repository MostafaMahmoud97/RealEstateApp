<?php


namespace App\Services\Admin;


use App\Http\Resources\Admin\Employee\PaginateIndexResource;
use App\Models\Admin;
use App\Models\TypeIdentity;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class EmployeeService
{

    public function store($request){
        $Employee = Admin::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return Response::successResponse($Employee,__("employee.Employee has been created success"));
    }

    public function index($request){
        $Employees = Admin::where(function ($q) use ($request){
            $q->where("name","like","%".$request->search."%")
                ->OrWhere("phone","like","%".$request->search."%")
                ->OrWhere("id","like","%".$request->search."%")
                ->OrWhere("email","like","%".$request->search."%");
        });

        if($request->is_active != ""&&($request->is_active == 0 || $request->is_active == 1)){
            $Employees->where("is_active",$request->is_active);
        }

        $Employees = $Employees->paginate(10);

        return Response::successResponse(PaginateIndexResource::make($Employees),__("employee.Employees have been fetched success"));
    }

    public function show($id){
        $Employee = Admin::find($id);
        if(!$Employee){
            return Response::errorResponse([],__("employee.no employee by this id"));
        }
        return Response::successResponse($Employee,__('employee.Employee has been fetched success'));
    }

    public function update($id,$request){
        $Employee = Admin::find($id);
        if(!$Employee){
            return Response::errorResponse([],__("employee.no employee by this id"));
        }
        $Employee->update($request->all());

        return Response::successResponse($Employee,__("employee.Employee has been updated success"));
    }

    public function resetPassword($id,$request){
        $Employee = Admin::find($id);
        if(!$Employee){
            return Response::errorResponse([],__("employee.no employee by this id"));
        }

        $Employee->update([
            "password" => Hash::make($request->password)
        ]);

        return Response::successResponse($Employee,__("employee.Employee has been reset password success"));
    }

    public function is_active($employee_id){
        $employee = Admin::find($employee_id);
        if(!$employee){
            return Response::errorResponse([],__("employee.no employee by this id"));
        }

        if($employee->is_active == 0){
            $employee->update([
                "is_active" => 1
            ]);
        }else{
            $employee->update([
                "is_active" => 0
            ]);
        }
        return Response::successResponse($employee,__("employee.Employee has been updated success"));
    }
}
