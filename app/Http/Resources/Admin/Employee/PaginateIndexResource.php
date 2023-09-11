<?php

namespace App\Http\Resources\Admin\Employee;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginateIndexResource extends JsonResource
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
            'total'           => $this->total(),
            'count'           => $this->count(),
            'per_page'        => $this->perPage(),
            'current_page'    => $this->currentPage(),
            'total_pages'     => $this->lastPage(),
            'data'            => EmployeeIndexResource::collection($this->items())
        ];
    }
}
