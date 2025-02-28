<?php

namespace App\Http\Resources;

use App\Actions\Pagination;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerOrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge([
            'orders' => $this->collection,
        ], Pagination::paginate($this));
    }
}
