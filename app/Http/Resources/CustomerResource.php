<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Address;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $division = Address::where('code', $this->division)
                            ->first();

        $township = Address::where('code', $this->township)
                            ->first();
        return [
            'id' => $this->id,
            'customer_number' => $this->user_number,
            'name' => $this->name,
            'image' => $this->image ? asset('customers/image/' . $this->image) : "",
            'phone' => $this->phone,
            'address' => $this->address,
            'shop' => $this->shop,
            'contact_name' => ($this->contact_name || $this->contact_name !== "") ? $this->contact_name : '-',
            'contact_phone' => $this->contact_phone ? $this->contact_phone : '-',
            'contact_position' => $this->contact_position ? $this->contact_position : '-',
            'type' => $this->type ? $this->type : '-',
            'township' => $township,
            'division' => $division,
            'order_count' => $this->orders->count(),
            'latest_order' => $this->orders()->latest()->first() ? dateFormat($this->orders()->latest()->first()?->order_date) : '-',
        ];
    }
}