<?php

namespace App\Http\Resources\Client\ManageRequest;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowDepositInvoiceResource extends JsonResource
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
            "deposit_invoice_id" => $this["DepositInvoice"]->id,
            "user_id" => $this->user_id,
            "deposit_price" => $this["DepositInvoice"]->deposit_price,
            "building_type" => $this["Unit"]["RealEstate"]["BuildingType"]->title,
            "address" => $this["Unit"]["RealEstate"]->national_address,
            "cover" => count($this["Unit"]['RealEstate']['Media']) > 0 ? $this["Unit"]['RealEstate']['Media'][0]->file_path : "",
        ];
    }
}
