<?php


namespace App\Services\Client;


use App\Models\BuildingType;
use App\Models\BuildingTypeUse;
use App\Models\ContractStatus;
use App\Models\DepositInvoiceStatus;
use App\Models\Nationality;
use App\Models\PurposeProperty;
use App\Models\RentPaymentCycle;
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
        $MyListingTaps = UnitStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $RentPaymentCycles = RentPaymentCycle::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")->get();
        $ContractTaps = UnitStatus::select("id","title_".LaravelLocalization::getCurrentLocale()." as title")
            ->whereNotIn("id",[1,2])->get();
        if (LaravelLocalization::getCurrentLocale() == "en"){
            $homeTaps = [
                [
                    "id" => "",
                    "title" => "All"
                ]
            ];

            $RequestStatusX = [
                [
                    "id" => 0,
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

            $RequestStatusX = [
                [
                    "id" => 0,
                    "title" => "الكل"
                ]
            ];
        }


        foreach ($BuildingType as $item){
            array_push($homeTaps , $item);
        }

        foreach ($RequestStatus as $status){
            array_push($RequestStatusX,$status);
        }


        $data = [
            "building_type" => $BuildingType,
            "building_type_use" => $BuildingTypeUse,
            "my_listing_taps" => $MyListingTaps,
            "contract_status" => $ContractStatus,
            "invoice_status" => $InvoiceStatus,
            "nationality" => $Nationality,
            "purpose_property" => $PurposeProperty,
            "request_status" => $RequestStatusX,
            "type_identity" => $TypeIdentity,
            "contract_taps" => $ContractTaps,
            "home_taps" => $homeTaps,
            "rent_payment_cycle" => $RentPaymentCycles
        ];

        return Response::successResponse($data,"data has been fetched");

    }
}
