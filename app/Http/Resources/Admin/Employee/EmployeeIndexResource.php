<?php

namespace App\Http\Resources\Admin\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeIndexResource extends JsonResource
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
            "phone" => $this->phone,
            "email" => $this->email,
            "is_active" => $this->is_active,
            "job_title" => $this->job_title,
            "logo" => $this['media']->file_path ? $this['media']->file_path : ""
        ];
    }
}
