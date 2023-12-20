<?php


namespace App\Services\Admin;


use App\Models\Contract;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class DashboardService
{
    public function getContracts($request){

        $CommercialArray = [];
        $ResidentialArray = [];

        for ($i = 1;$i <= 12; $i++){
            if ($i < 10){
                $month = "0".$i;
            }else{
                $month = $i;
            }

            $CommercialContractCount = Contract::where("contract_status_id",3)
                ->where("created_at","like","%".$request->year."-".$month."%")
                ->whereHas("Request" , function ($q){
                    $q->whereHas("Unit",function ($q){
                        $q->withTrashed()->whereHas("RealEstate",function ($q){
                            $q->withTrashed()->where("building_type_use_id",1);
                        });
                    });
                })->get()->count();

            array_push($CommercialArray,$CommercialContractCount);

            $ResidentialContractCount = Contract::where("contract_status_id",3)
                ->where("created_at","like","%".$request->year."-".$month."%")
                ->whereHas("Request" , function ($q){
                    $q->whereHas("Unit",function ($q){
                        $q->withTrashed()->whereHas("RealEstate",function ($q){
                            $q->withTrashed()->where("building_type_use_id",2);
                        });
                    });
                })->get()->count();

            array_push($ResidentialArray,$ResidentialContractCount);
        }

        $TotalContract = Contract::where("contract_status_id",3)
            ->where("created_at","like","%".$request->year."%")
            ->get()->count();

        $TotalCommercialContracts = Contract::where("contract_status_id",3)
            ->where("created_at","like","%".$request->year."%")
            ->whereHas("Request" , function ($q){
                $q->whereHas("Unit",function ($q){
                    $q->withTrashed()->whereHas("RealEstate",function ($q){
                        $q->withTrashed()->where("building_type_use_id",1);
                    });
                });
            })->get()->count();

        $TotalResidentialContracts = Contract::where("contract_status_id",3)
            ->where("created_at","like","%".$request->year."%")
            ->whereHas("Request" , function ($q){
                $q->whereHas("Unit",function ($q){
                    $q->withTrashed()->whereHas("RealEstate",function ($q){
                        $q->withTrashed()->where("building_type_use_id",2);
                    });
                });
            })->get()->count();


        $data = [
            "commercial_contract_monthly" => $CommercialArray,
            "residential_contract_monthly" => $ResidentialArray,
            "total_contract" => $TotalContract,
            "total_commercial_contracts" => $TotalCommercialContracts,
            "total_residential_contracts" => $TotalResidentialContracts,
        ];

        return Response::successResponse($data);
    }

    public function getUsers(){
        $ActiveUsersCount = User::where("is_active",1)->get()->count();
        $InActiveUsersCount = User::where("is_active",0)->get()->count();

        $data = [
            "active_users" => $ActiveUsersCount,
            "in_active_users" => $InActiveUsersCount
        ];
        return Response::successResponse($data);
    }

    public function getDeals($request){
        $TotalDealsArray = [];

        for ($i = 1;$i <= 12; $i++){
            if ($i < 10){
                $month = "0".$i;
            }else{
                $month = $i;
            }

            $DealsCount = Contract::where("contract_status_id","!=",4)
                ->where("created_at","like","%".$request->year."-".$month."%")
                ->get()->count();

            array_push($TotalDealsArray,$DealsCount);
        }

        $RegistryPendingCount = Contract::where("contract_status_id",1)
            ->where("created_at","like","%".$request->year."%")
            ->get()->count();

        $RegistryProcessingCount = Contract::where("contract_status_id",2)
            ->where("created_at","like","%".$request->year."%")
            ->get()->count();

        $RegistryUploadedCount = Contract::where("contract_status_id",3)
            ->where("created_at","like","%".$request->year."%")
            ->get()->count();

        $data = [
            "deals" => $TotalDealsArray,
            "registry_pending" => $RegistryPendingCount,
            "registry_processing" => $RegistryProcessingCount,
            "registry_uploaded" => $RegistryUploadedCount,
        ];

        return Response::successResponse($data);
    }

    public function getUnits($request){
        $UnitsArray = [];

        for ($i = 1;$i <= 12; $i++){
            if ($i < 10){
                $month = "0".$i;
            }else{
                $month = $i;
            }

            $UnitsCount = Unit::where("created_at","like","%".$request->year."-".$month."%")
                ->get()->count();

            array_push($UnitsArray,$UnitsCount);
        }

        $TotalRentUnits = Unit::where("purpose_property_id",1)
        ->where("created_at","like","%".$request->year."%")
            ->get()->count();

        $TotalSaleUnits = Unit::where("purpose_property_id",2)
            ->where("created_at","like","%".$request->year."%")
            ->get()->count();

        $data = [
            "units_monthly" => $UnitsArray,
            "rent_units" => $TotalRentUnits,
            "sell_units" => $TotalSaleUnits,
        ];

        return Response::successResponse($data);

    }
}
