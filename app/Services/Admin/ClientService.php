<?php


namespace App\Services\Admin;


use App\Http\Resources\Admin\Client\PaginateIndexResource;
use App\Models\TypeIdentity;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ClientService
{
    public function getTypeIdentities(){
        $TypeIdentities = TypeIdentity::select("id",LaravelLocalization::getCurrentLocale()."_title")->get();
        return Response::successResponse($TypeIdentities,__("client.Type identities have been fetched"));
    }

    public function store($request){
        $User = User::create([
            "type_identities_id" => $request->type_id,
            "name" => $request->name,
            "nationality" => $request->nationality,
            "id_number" => $request->id_number,
            "phone" => $request->phone,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);


        return Response::successResponse($User,__("client.Client has been created success"));
    }

    public function index($request){
        $Clients = User::where(function ($q) use ($request){
            $q->where("name","like","%".$request->search."%")
                ->OrWhere("phone","like","%".$request->search."%")
                ->OrWhere("id",$request->search)
                ->OrWhere("email","like","%".$request->search."%")
                ->OrWhere("id_number","like","%".$request->search."%");
        });


        if($request->is_active != ""&&($request->is_active == 0 || $request->is_active == 1)){
            $Clients->where("is_active",$request->is_active);
        }

        $Clients = $Clients->paginate(10);

        return Response::successResponse(PaginateIndexResource::make($Clients),__("client.Clients have been fetched success"));
    }

    public function show($id){
        $Client = User::find($id);
        if(!$Client){
            return Response::errorResponse([],__("client.no client by this id"));
        }
        return Response::successResponse($Client,__('client.Client has been fetched success'));
    }

    public function update($id,$request){
        $Client = User::find($id);
        if(!$Client){
            return Response::errorResponse([],__("client.no client by this id"));
        }
        $Client->update($request->all());

        return Response::successResponse($Client,__("client.Client has been updated success"));
    }

    public function resetPassword($id,$request){
        $Client = User::find($id);
        if(!$Client){
            return Response::errorResponse([],__("client.no client by this id"));
        }

        $Client->update([
            "password" => Hash::make($request->password)
        ]);

        return Response::successResponse($Client,__("client.Client has been reset password success"));
    }

    public function is_active($client_id){
        $client = User::find($client_id);
        if(!$client){
            return Response::errorResponse([],__("client.no client by this id"));
        }

        if($client->is_active == 0){
            $client->update([
                "is_active" => 1
            ]);
        }else{
            $client->update([
                "is_active" => 0
            ]);
        }
        return Response::successResponse($client,__("client.Client has been updated success"));
    }
}