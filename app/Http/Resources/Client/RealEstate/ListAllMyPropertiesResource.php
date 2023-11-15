<?php

namespace App\Http\Resources\Client\RealEstate;

use Illuminate\Http\Resources\Json\JsonResource;

class ListAllMyPropertiesResource extends JsonResource
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
            "unit_number" => $this->unit_number,
            "unit_area" => $this->unit_area,
            "price" => $this->price,
            "address" => $this['RealEstate']->national_address,
            "building_type" => $this['RealEstate']['BuildingType']->title,
            "building_type_use" => $this['RealEstate']['BuildingTypeUse']->title,
            "purpose" => $this['PurposeProperty']->title,
            "CoverRealEstate" => count($this['RealEstate']['Media']) > 0 ? $this['RealEstate']['Media'][0]->file_path : "",
        ];
    }
}
