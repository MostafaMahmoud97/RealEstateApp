<?php

namespace App\Http\Resources\Client\Deals;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexBeneficiaryContractResource extends JsonResource
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
            "user_name" => $this["Request"]["Unit"]["RealEstate"]["User"]->name,
            "email" => $this["Request"]["Unit"]["RealEstate"]["User"]->email,
            "building_type" => $this["Request"]["Unit"]["RealEstate"]["BuildingType"]->title,
            "address" => $this["Request"]["Unit"]["RealEstate"]->national_address,
            "status" => $this["ContractStatus"]->title,
            "created_at" => $this->created_at,
            "cover" => count($this["Request"]["Unit"]["RealEstate"]["media"]) > 0 ? $this["Request"]["Unit"]["RealEstate"]["media"][0]->file_path : "",
            "contract" => $this["media"] ? $this["media"]->file_path : "",
        ];
    }
}
