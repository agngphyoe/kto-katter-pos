<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'location_name' => $this->location_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'location_type_id' => $this->location_type_id,
            'created_by' => $this->created_by,
        ];
    }
}
