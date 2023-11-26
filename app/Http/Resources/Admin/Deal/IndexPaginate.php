<?php

namespace App\Http\Resources\Admin\Deal;

use Illuminate\Http\Resources\Json\JsonResource;

class IndexPaginate extends JsonResource
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
            'data'            => IndexResource::collection($this->items())
        ];
    }
}
