<?php


namespace App\Services\Client;


use App\Models\BuildingType;
use App\Models\BuildingTypeUse;
use App\Models\ContractStatus;
use App\Models\DepositInvoiceStatus;
use App\Models\Nationality;
use App\Models\PurposeProperty;
use App\Models\RequestStatus;
use App\Models\TypeIdentity;
use App\Models\UnitStatus;
use Illuminate\Support\Facades\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SettingService
{
    public function all_help_data(){
        $BuildingType = BuildingType::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $BuildingTypeUse = BuildingTypeUse::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $ContractStatus = ContractStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $InvoiceStatus = DepositInvoiceStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $Nationality = Nationality::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $PurposeProperty = PurposeProperty::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $RequestStatus = RequestStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $TypeIdentity = TypeIdentity::select("id",LaravelLocalization::getCurrentLocale()."_title as title")->get();
        $ContractTaps = UnitStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")
            ->whereNotIn("id",[1,2])->get();
        if (LaravelLocalization::getCurrentLocale() == "er"){
            $homeTaps = [
                [
                    "id" => "",
                    "title" => "All"
                ]
            ];
        }else{
            $homeTaps = [
                [
                    "id" => "",
                    "title" => "الكل"
                ]
            ];
        }


        foreach ($BuildingType as $item){
            array_push($homeTaps , $item);
        }


        $data = [
            "building_type" => $BuildingType,
            "building_type_use" => $BuildingTypeUse,
            "contract_status" => $ContractStatus,
            "invoice_status" => $InvoiceStatus,
            "nationality" => $Nationality,
            "purpose_property" => $PurposeProperty,
            "request_status" => $RequestStatus,
            "type_identity" => $TypeIdentity,
            "contract_taps" => $ContractTaps,
            "home_taps" => $homeTaps
        ];

        return Response::successResponse($data,"data has been fetched");

    }
}
