<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'price' => $this->price,
            'retail_price' => $this->retail_price,
            'wholesale_price' => $this->wholesale_price,
            'brand' => $this->brand?->name,
            'category' => $this->category?->name,
            'model' => $this->productModel?->name,
            'type' => $this->type?->name,
            'design' => $this->design?->name,
            'quantity' => $this->quantity,
            'image' => $this->image ? asset('products/image/' . $this->image) : '',
        ];
    }
}
