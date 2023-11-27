<?php


namespace App\Services\Client;


use App\Http\Resources\Client\Deals\IndexBeneficiaryContractPaginateResource;
use App\Http\Resources\Client\Deals\IndexMyContractPaginateResource;
use App\Models\Contract;
use App\Models\UnitStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DealClientService
{
    public function DealStatusList(){
        $UnitStatus = UnitStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")
            ->whereNotIn("id",[1,2])->get();
        return Response::successResponse($UnitStatus,__("deals.Status have been fetched success"));
    }

    public function index($request){
        $Contract = Contract::with(["ContractStatus" => function($q){
            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
        },"Request" => function($q){
            $q->with(["User","Unit" => function($q){
                $q->with(["RealEstate" => function($q){
                    $q->with(["User","media","BuildingType" => function($q){
                        $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                    }]);
                }]);
            }]);
        }]);

        if ($request->status_id == 3){
            $Contract = $Contract->whereHas("Request" , function ($q){
                $q->whereHas("Unit",function ($q){
                    $q->whereHas("RealEstate",function ($q){
                        $q->where("user_id",Auth::id());
                    })->where("purpose_property_id",2);
                });
            });
        }elseif ($request->status_id == 4){
            $Contract = $Contract->whereHas("Request" , function ($q){
                $q->whereHas("Unit",function ($q){
                    $q->whereHas("RealEstate",function ($q){
                    })->where("purpose_property_id",2);
                })->where("user_id",Auth::id());
            });
        }elseif ($request->status_id == 5){
            $Contract = $Contract->whereHas("Request" , function ($q){
                $q->whereHas("Unit",function ($q){
                    $q->whereHas("RealEstate",function ($q){
                        $q->where("user_id",Auth::id());
                    })->where("purpose_property_id",1);
                });
            });
        }elseif ($request->status_id == 6){
            $Contract = $Contract->whereHas("Request" , function ($q){
                $q->whereHas("Unit",function ($q){
                    $q->whereHas("RealEstate",function ($q){
                    })->where("purpose_property_id",1);
                })->where("user_id",Auth::id());
            });
        }

        $Contract = $Contract->paginate(10);

        if ($request->status_id == 4 || $request->status_id == 6){
            return Response::successResponse(IndexBeneficiaryContractPaginateResource::make($Contract),__("deals.contracts have been fetched success"));
        }else{
            return Response::successResponse(IndexMyContractPaginateResource::make($Contract),__("deals.contracts have been fetched success"));
        }
    }
}
