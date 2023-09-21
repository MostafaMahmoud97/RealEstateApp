<?php

namespace App\Http\Resources\Client\RealEstate;

use Illuminate\Http\Resources\Json\JsonResource;

class editRealEstateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "national_address" => $this->national_address,
            "lat" => $this->lat,
            "lon" => $this->lon,
            "number_floors" => $this->number_floors,
            "number_units" => $this->number_units,
            "number_parking_lots" => $this->number_parking_lots,
            "building_type_id" => $this['BuildingType']->id,
            "building_type" => $this['BuildingType']->title,
            "building_type_use_id" => $this["BuildingTypeUse"]->id,
            "building_type_use" => $this["BuildingTypeUse"]->title,
            "cover_id" => count($this['media']) > 0 ? $this['media'][0]->id : "",
            "cover" => count($this['media']) > 0 ? $this['media'][0]->file_path : "",
            "units" => editUnitResource::collection($this['Units'])
        ];
    }
}
