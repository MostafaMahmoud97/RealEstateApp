<?php

namespace App\Http\Resources\Admin\Deal;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "contract_data" => [
                "contract_sealing_date" => $this["Request"]->contract_sealing_date,
                "tenancy_start_date" => $this["Request"]->contract_sealing_date,
                "tenancy_end_date" => $this["Request"]->tenancy_end_date
            ],
            "lessor_data" => [
                "name" => $this["Request"]["Unit"]["RealEstate"]["User"]->name,
                "nationality" => $this["Request"]["Unit"]["RealEstate"]["User"]["Nationality"]->title,
                "id_type" => $this["Request"]["Unit"]["RealEstate"]["User"]["TypeIdentity"]->title,
                "id_no" => $this["Request"]["Unit"]["RealEstate"]["User"]->id_number,
                "mobile_no" => $this["Request"]["Unit"]["RealEstate"]["User"]->phone,
                "email" => $this["Request"]["Unit"]["RealEstate"]["User"]->email,
            ],
            "tenant_data" => [
                "name" => $this["Request"]["User"]->name,
                "nationality" => $this["Request"]["User"]["Nationality"]->title,
                "id_type" => $this["Request"]["User"]["TypeIdentity"]->title,
                "id_no" => $this["Request"]["User"]->id_number,
                "mobile_no" => $this["Request"]["User"]->phone,
                "email" => $this["Request"]["User"]->email,
            ],
            "property_data" => [
                "nationality_address" => $this["Request"]["Unit"]["RealEstate"]->national_address,
                "property_type" => $this["Request"]["Unit"]["RealEstate"]["BuildingType"]->title,
                "property_usage" => $this["Request"]["Unit"]["RealEstate"]["BuildingTypeUse"]->title,
                "number_of_floors" => $this["Request"]["Unit"]["RealEstate"]->number_floors,
                "number_of_units" => $this["Request"]["Unit"]["RealEstate"]->number_units,
                "number_of_parking_lots" => $this["Request"]["Unit"]["RealEstate"]->number_parking_lots
            ],
            "rental_units_data" => [
                "unit_no" => $this["Request"]["Unit"]->unit_number,
                "unit_type" => $this["Request"]["Unit"]->unit_type,
                "unit_area" => $this["Request"]["Unit"]->unit_area,
                "floor_number" => $this["Request"]["Unit"]->floor_number,
                "composite_kitchen_cabinets" => $this["Request"]["Unit"]->composite_kitchen_cabinets,
                "furnished" => $this["Request"]["Unit"]->furnished,
                "ac_type" => $this["Request"]["Unit"]->ac_type,
                "num_ac_units" => $this["Request"]["Unit"]->num_ac_units,
                "electricity_meter_number" => $this["Request"]["Unit"]->electricity_meter_number,
                "electricity_meter_reading" => $this["Request"]["Unit"]->electricity_meter_reading,
                "gas_meter_number" => $this["Request"]["Unit"]->gas_meter_number,
                "gas_meter_reading" => $this["Request"]["Unit"]->gas_meter_reading,
                "water_meter_number" => $this["Request"]["Unit"]->water_meter_number,
                "water_meter_reading" => $this["Request"]["Unit"]->water_meter_reading,
            ]
        ];

        $CommercialUnitData = [
            "unit_length" => $this["Request"]["Unit"]["CommercialInfo"]->unit_length,
            "unit_direction" => $this["Request"]["Unit"]["CommercialInfo"]->unit_direction,
            "number_parking_lots" => $this["Request"]["Unit"]["CommercialInfo"]->number_parking_lots,
            "sign_location" => $this["Request"]["Unit"]["CommercialInfo"]->sign_location,
            "special_sign_specification" => $this["Request"]["Unit"]["CommercialInfo"]->special_sign_specification,
            "insurance_policy_number" => $this["Request"]["Unit"]["CommercialInfo"]->insurance_policy_number,
            "mezzanine" => $this["Request"]["Unit"]["CommercialInfo"]->mezzanine,
            "unit_finishing" => $this["Request"]["Unit"]["CommercialInfo"]->unit_finishing,
        ];

        $CommercialActivity = [
            "name" => $this["Request"]["Unit"]["CommercialActivity"]->company_name,
            "cr_number" => $this["Request"]["Unit"]["CommercialActivity"]->cr_number,
            "cr_issued_at" => $this["Request"]["Unit"]["CommercialActivity"]->issued_by,
            "cr_issued_date" => $this["Request"]["Unit"]["CommercialActivity"]->cr_date,
            "licence_number" => $this["Request"]["Unit"]["CommercialActivity"]->licence_number,
            "licence_issue_place" => $this["Request"]["Unit"]["CommercialActivity"]->licence_issue_place,
            "organization_type" => $this["Request"]["Unit"]["CommercialActivity"]->organization_type,
            "unified_number" => $this["Request"]["Unit"]["CommercialActivity"]->unified_number,
            "modify_business" => $this["Request"]["Unit"]["CommercialActivity"]->modify_business,
        ];

        if($this["Request"]["Unit"]["RealEstate"]["BuildingTypeUse"]->id == 1){
            $data["rental_units_data"]["commercial_unit_data"] = $CommercialUnitData;
            $data["tenant_commercial_activities"] = $CommercialActivity;
        }

        $finance_data = [
            "security_deposit" => $this["Request"]["Unit"]->security_deposit,
            "annual_rent" => $this["Request"]->annual_rent,
            "rent_payment_cycle" => $this["Request"]["RentPaymentCycle"]->title,
            "regular_rent_payment" => $this["Request"]->regular_rent_payment
        ];

        $data["financial_data"] = $finance_data;

        return $data;

    }
}
