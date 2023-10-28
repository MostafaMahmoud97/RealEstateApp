<?php

namespace App\Http\Resources\Client\ManageRequest;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowReceivedRequestsResource extends JsonResource
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
            "rent_payment_cycle" => $this["RentPaymentCycle"]->title,
            "contract_sealing_date" => $this->contract_sealing_date,
            "tenancy_end_date" => $this->tenancy_end_date,
            "annual_rent" => $this->annual_rent,
            "regular_rent_payment" => $this->regular_rent_payment,
            "security_deposit" => $this["Unit"]->security_deposit,
            "user" => $this["User"]
        ];
    }
}
