<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequestResource extends JsonResource
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
            'id' => $this->id,
            'request_inv_code' => $this->request_inv_code,
            'from_location_id' => $this->from_location_id,
            'to_location_id' => $this->to_location_id,
            'product_id' => $this->product_id,
            'created_by' => $this->created_by,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'remark' => $this->remark,
            'user' => new CustomerResource($this->user),
            'fromLocationName' => new LocationResource($this->fromLocationName),
            'toLocationName' => new LocationResource($this->toLocationName),
            'product' => new ProductResource($this->product)
        ];
    }
}
