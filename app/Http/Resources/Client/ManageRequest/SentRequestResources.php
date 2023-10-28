<?php

namespace App\Http\Resources\Client\ManageRequest;

use Illuminate\Http\Resources\Json\JsonResource;

class SentRequestResources extends JsonResource
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
            "purpose_property" => $this["Unit"]["PurposeProperty"]->title,
            "address" => $this["Unit"]['RealEstate']->national_address,
            "building_type" => $this["Unit"]['RealEstate']['BuildingType']->title,
            "building_type_use" => $this["Unit"]['RealEstate']['BuildingTypeUse']->title,
            "status_id" => $this["RequestStatus"]->id,
            "status" => $this["RequestStatus"]->title,
            "CoverRealEstate" => count($this["Unit"]['RealEstate']['Media']) > 0 ? $this["Unit"]['RealEstate']['Media'][0]->file_path : "",
        ];
    }
}
