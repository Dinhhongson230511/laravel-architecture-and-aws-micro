<?php

namespace App\Http\Resources\OrderItem;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'order_id ' => $this->order_id,
            'product_title' => $this->product_title,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}
