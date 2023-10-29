<?php

namespace App\Http\Resources\Client\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowUserResource extends JsonResource
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
            "name" => $this->name,
            "id_number" => $this->id_number,
            "phone" => $this->phone,
            "email" => $this->email,
            "type_identity_id" => $this['TypeIdentity']->id,
            "type_identity" => $this['TypeIdentity']->title,
        ];
    }
}
