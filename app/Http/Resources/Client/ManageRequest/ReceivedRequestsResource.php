<?php

namespace App\Http\Resources\Client\ManageRequest;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceivedRequestsResource extends JsonResource
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
            "request_id" => $this->id,
            "user" => $this["User"],
            "unit_number" => $this["Unit"]->unit_number,
            "unit_area" => $this["Unit"]->unit_area,
            "price" => $this["Unit"]->price,
            "purpose_property" => $this["Unit"]["PurposeProperty"]->title,
            "address" => $this["Unit"]['RealEstate']->national_address,
            "building_type" => $this["Unit"]['RealEstate']['BuildingType']->title,
            "building_type_use" => $this["Unit"]['RealEstate']['BuildingTypeUse']->title,
            "CoverRealEstate" => count($this["Unit"]['RealEstate']['Media']) > 0 ? $this["Unit"]['RealEstate']['Media'][0]->file_path : "",
        ];
    }
}
