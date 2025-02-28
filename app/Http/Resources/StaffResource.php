<?php

namespace App\Http\Resources;

use App\Models\Position;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'staff_number' => $this->user_number,
            'name' => $this->name,
            'image' => $this->image ? asset('staffs/image' . $this->image) : '',
            'position' => $this->position?->name,
            'phone' => $this->phone,
            'company_id' => $this->company_id,
            'company' => $this->company?->name,
            'division' => $this->division?->name,
            'township' => $this->township?->name,
        ];
    }
}
