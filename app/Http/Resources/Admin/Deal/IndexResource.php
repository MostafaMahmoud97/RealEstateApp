<?php

namespace App\Http\Resources\Admin\Deal;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
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
            "first_party" => $this["Request"]["Unit"]["RealEstate"]["User"]->name,
            "second_party" => $this["request"]["user"]->name,
            "deal_type" => $this["Request"]["Unit"]["PurposeProperty"]->title,
            "space_usage" => $this["Request"]["Unit"]["RealEstate"]["BuildingTypeUse"]->title,
            "registry_cost" => $this["Request"]["DepositInvoice"]["InvoiceStatus"]->title,
            "registry_status" => $this["ContractStatus"]->title
        ];
    }
}
