<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTransferResource extends JsonResource
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
            'transfer_inv_code' => $this->transfer_inv_code,
            'from_location_id' => $this->from_location_id,
            'to_location_id' => $this->to_location_id,
            'product_id' => $this->product_id,
            'created_by' => $this->created_by,
            'transfer_qty' => $this->transfer_qty,
            'stock_qty' => $this->stock_qty,
            'status' => $this->status,
            'transfer_type' => $this->transfer_type,
            'remark' => $this->remark,
            'transfer_date' => $this->transfer_date,
            'user' => new CustomerResource($this->user),
            'fromLocationName' => new LocationResource($this->fromLocationName),
            'toLocationName' => new LocationResource($this->toLocationName),
            'product' => new ProductResource($this->product)
        ];
    }
}
