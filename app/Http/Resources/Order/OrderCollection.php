<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => OrderResource::collection($this->collection),
            'paginate' => [
                'current_page' => $this->resource->currentPage(),
                'num_page' => $this->resource->lastPage(),
                'total' => $this->resource->total(),
            ]
        ];
    }
}