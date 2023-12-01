<?php

namespace App\Http\Resources\Client\Notification;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
            "data" => [
                "title" => $this->data["title_".LaravelLocalization::getCurrentLocale()],
                "content" => $this->data["content_".LaravelLocalization::getCurrentLocale()],
                "code" => $this->data["code"],
            ]
        ];
    }
}
