<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerOrderResource extends JsonResource
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
            'order_status' => $this->order_status,
            'order_request' => $this->order_request,
            'total_quantity' => $this->total_quantity,
            'total_amount'  => $this->total_amount,
            'order_date'    => $this->order_date,
        ];
    }
}
