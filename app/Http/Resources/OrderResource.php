<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'            => $this->id,
            'order_number'  => $this->order_number,
            'customer_id' => $this->customer_id,
            'customer'      => new CustomerResource($this->customer),
            'order_status' => $this->order_status,
            'order_request' => $this->order_request,
            'total_quantity' => $this->total_quantity,
            'total_amount'  => $this->total_amount,
            'order_date'    => $this->order_date,
        ];
    }
}