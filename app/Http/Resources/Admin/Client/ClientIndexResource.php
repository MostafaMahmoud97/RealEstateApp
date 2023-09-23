<?php

namespace App\Http\Resources\Admin\Client;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientIndexResource extends JsonResource
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
            "full_name" => $this->name,
            "nationality" => $this['Nationality']->title,
            "id_number" => $this->id_number,
            "phone" => $this->phone,
            "email" => $this->email,
            "is_active" => $this->is_active
        ];
    }
}
