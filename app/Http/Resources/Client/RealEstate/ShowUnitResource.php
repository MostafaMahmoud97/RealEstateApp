<?php

namespace App\Http\Resources\Client\RealEstate;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this['RealEstate']['BuildingTypeUse']->id == 1){
            return [
                "id" => $this->id,
                "building_type" => $this['RealEstate']['BuildingType']->title,
                "address" => $this['RealEstate']->national_address,
                "lat" => $this["RealEstate"]->lat,
                "lon" => $this["RealEstate"]->lon,
                "unit_number" => $this->unit_number,
                "unit_area" => $this->unit_area,
                "activity" => $this['RealEstate']['BuildingTypeUse']->title,
                "price" => $this->price,
                "user" => $this["RealEstate"]->User,
                "description" => $this->description,
                "purpose" => $this['PurposeProperty']->title,
                "unit_type" => $this->unit_type,
                "floor_number" => $this->floor_number,
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
                "CoverRealEstate" => count($this['RealEstate']['Media']) > 0 ? $this['RealEstate']['Media'][0]->file_path : "",
                "media" => $this['Media'],
                "updated" => $this->updated_at,

                "unit_length" => $this["CommercialInfo"]->unit_length,
                "unit_direction" => $this["CommercialInfo"]->unit_direction,
                "number_parking_lots" => $this["CommercialInfo"]->number_parking_lots,
                "sign_area" => $this["CommercialInfo"]->sign_area,
                "sign_location" => $this["CommercialInfo"]->sign_location,
                "special_sign_specification" => $this["CommercialInfo"]->special_sign_specification,
                "insurance_policy_number" => $this["CommercialInfo"]->insurance_policy_number,
                "mezzanine" => $this["CommercialInfo"]->mezzanine,
                "unit_finishing" => $this["CommercialInfo"]->unit_finishing,
            ];


        }else{
            return [
                "id" => $this->id,
                "building_type" => $this['RealEstate']['BuildingType']->title,
                "address" => $this['RealEstate']->national_address,
                "lat" => $this["RealEstate"]->lat,
                "lon" => $this["RealEstate"]->lon,
                "unit_number" => $this->unit_number,
                "unit_area" => $this->unit_area,
                "activity" => $this['RealEstate']['BuildingTypeUse']->title,
                "price" => $this->price,
                "user" => $this["RealEstate"]->User,
                "description" => $this->description,
                "purpose" => $this['PurposeProperty']->title,
                "unit_type" => $this->unit_type,
                "floor_number" => $this->floor_number,
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
                "CoverRealEstate" => count($this['RealEstate']['Media']) > 0 ? $this['RealEstate']['Media'][0]->file_path : "",
                "media" => $this['Media'],
                "updated" => $this->updated_at,
            ];
        }
    }
}
