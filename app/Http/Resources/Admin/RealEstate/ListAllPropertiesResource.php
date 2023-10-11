<?php

namespace App\Http\Resources\Admin\RealEstate;

use Illuminate\Http\Resources\Json\JsonResource;

class ListAllPropertiesResource extends JsonResource
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
            "purpose" => $this->PurposeProperty->title,
            "activity" => $this['RealEstate']['BuildingTypeUse']->title,

            "address" => $this['RealEstate']->national_address,
            "real_estate_type" => $this['RealEstate']['BuildingType']->title,
            "beneficiary" => $this->Beneficiary ? $this->Beneficiary->name : "",
            "status" => $this->user_id == $this->beneficiary_id ? $this->BeneficiaryStatus->title : $this->UnitStatus->title,
            "price" => $this->price,
        ];
    }
}
