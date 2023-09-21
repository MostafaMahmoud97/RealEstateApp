<?php

namespace App\Http\Resources\Client\RealEstate;

use Illuminate\Http\Resources\Json\JsonResource;

class editUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!$this['CommercialInfo']){
            return [
                "id" => $this->id,
                "purpose_property_id" => $this['PurposeProperty']->id,
                "purpose_property" => $this['PurposeProperty']->title,
                "price" => $this->price,
                "unit_type" => $this->unit_type,
                "unit_number" => $this->unit_number,
                "floor_number" => $this->floor_number,
                "unit_area" => $this->unit_area,
                "furnished" => $this->furnished,
                "composite_kitchen_cabinets" => $this->composite_kitchen_cabinets,
                "ac_type" => $this->ac_type,
                "num_ac_units" => $this->num_ac_units,
                "electricity_meter_number" => $this->electricity_meter_number,
                "electricity_meter_reading" => $this->electricity_meter_reading,
                "gas_meter_number" => $this->gas_meter_number,
                "gas_meter_reading" => $this->gas_meter_reading,
                "water_meter_number" => $this->water_meter_number,
                "water_meter_reading" => $this->water_meter_reading,
                "description" => $this->description,
                "is_publish" => $this->is_publish,
                "media" => $this["Media"]
            ];
        }else{
            return [
                "id" => $this->id,
                "purpose_property_id" => $this['PurposeProperty']->id,
                "purpose_property" => $this['PurposeProperty']->title,
                "price" => $this->price,
                "unit_type" => $this->unit_type,
                "unit_number" => $this->unit_number,
                "floor_number" => $this->floor_number,
                "unit_area" => $this->unit_area,
                "furnished" => $this->furnished,
                "composite_kitchen_cabinets" => $this->composite_kitchen_cabinets,
                "ac_type" => $this->ac_type,
                "num_ac_units" => $this->num_ac_units,
                "electricity_meter_number" => $this->electricity_meter_number,
                "electricity_meter_reading" => $this->electricity_meter_reading,
                "gas_meter_number" => $this->gas_meter_number,
                "gas_meter_reading" => $this->gas_meter_reading,
                "water_meter_number" => $this->water_meter_number,
                "water_meter_reading" => $this->water_meter_reading,
                "description" => $this->description,
                "is_publish" => $this->is_publish,
                "media" => $this["Media"],
                "commercial_info" => [
                    "id" => $this['CommercialInfo']->id,
                    "unit_length" => $this['CommercialInfo']->unit_length,
                    "unit_direction" => $this['CommercialInfo']->unit_direction,
                    "number_parking_lots" => $this['CommercialInfo']->number_parking_lots,
                    "sign_area" => $this['CommercialInfo']->sign_area,
                    "sign_location" => $this['CommercialInfo']->sign_location,
                    "special_sign_specification" => $this['CommercialInfo']->special_sign_specification,
                    "insurance_policy_number" => $this['CommercialInfo']->insurance_policy_number,
                    "unit_finishing" => $this['CommercialInfo']->unit_finishing,
                ]
            ];
        }
    }
}
