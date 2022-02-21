<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return $this->resource->only([
            'id',
            'customer_id',
            'state_id',
            'sub_total',
            'tax',
            'total',
            'order_items',
        ]);
    }
}
