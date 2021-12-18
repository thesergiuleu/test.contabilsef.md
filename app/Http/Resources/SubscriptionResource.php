<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'package' => $this->resource->package,
            'payment' => $this->resource->payment,
            'service' => $this->resource->service,
            'status' => $this->resource->status(),
            'user' => $this->resource->user,
            'expired_at' => $this->resource->expired_at,
        ];
    }
}
