<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Address;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $division = 'Hello';
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'saleable_id' => $this->saleable_id,
            'saleable_type' => $this->saleable_type,
            'saleableby_id' => $this->saleableby_id,
            'saleableby_type' => $this->saleableby_type,
            'division' => $this->division,
            'township' => $this->township,
            'cash_down' => $this->cash_down,
            'tax_amount' => $this->tax_amount,
            'delivery_amount' => $this->delivery_amount,
            'total_quantity' => $this->total_quantity,
            'total_amount' => $this->total_amount,
            'total_paid_amount' => $this->total_paid_amount,
            'remaining_amount' => $this->remaining_amount,
            'payment_type' => $this->payment_type,
            'action_type' => $this->action_type,
            'sale_process' => $this->sale_process,
            'sale_status' => $this->sale_status,
            'action_date' => $this->action_date,
            'due_date' => $this->due_date,
            'sale_address' => $this->address,
            'customer' => $this->saleableby,
            'customer_township' => $this->whenLoaded('saleableBy.township'),
            'customer_division' => $this->whenLoaded('saleableBy.division'),
            'order' => $this->saleable,
            'products' => $this->whenLoaded('saleable.orderProducts.product'),
            'delivery' =>$this->delivery,
            // 'division' => $this->division,
            // 'township' => $this->township
        ];
    }
}
