<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'alias' => $this->resource->alias,
            'name' => $this->resource->name,
            'price' => $this->resource->price,
            'discount' => $this->resource->getDiscount(),
            'discount_started_at' => $this->resource->discount_started_at,
            'discount_ended_at' => $this->resource->discount_ended_at,
        ];
    }
}
