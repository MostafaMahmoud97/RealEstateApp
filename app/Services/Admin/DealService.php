<?php


namespace App\Services\Admin;


use App\Http\Resources\Admin\Deal\IndexPaginate;
use App\Models\Contract;
use App\Models\ContractStatus;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DealService
{
    public function getContractStatus(){
        $ContractStatus = ContractStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        return Response::successResponse($ContractStatus,__("deals.status has been fetched success"));
    }

    public function index($request){
        $Contracts = Contract::with(["Request" => function ($q){
            $q->with(["User","Unit" => function($q){
                $q->with(["RealEstate" => function($q){
                    $q->with(["User","BuildingTypeUse" => function($q){
                        $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                    }]);
                },"PurposeProperty" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            },"DepositInvoice" => function($q){
                $q->with(["InvoiceStatus" => function($q){
                    $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
                }]);
            }]);
        },"ContractStatus" => function($q){
            $q->select("id","title_".LaravelLocalization::getCurrentLocale()." as title");
        }])->whereHas("Request" ,function ($q) use ($request){
            $q->whereHas("User",function ($q) use ($request){
                $q->where("name","like","%".$request->search."%");
            })->OrWhereHas("Unit",function ($q) use ($request){
                $q->whereHas("RealEstate",function ($q) use ($request){
                    $q->whereHas("User",function ($q) use ($request){
                        $q->where("name","like","%".$request->search."%");
                    });
                });
            });
        })->OrWhere("id",$request->search);

        if ($request->status != 0){
            $Contracts = $Contracts->where("contract_status_id" , $request->status);
        }

        $Contracts = $Contracts->paginate(10);

        return Response::successResponse(IndexPaginate::make($Contracts),__("deals.Deals have been fetched success"));
    }

    public function showDeal($deal_id){

    }
}
