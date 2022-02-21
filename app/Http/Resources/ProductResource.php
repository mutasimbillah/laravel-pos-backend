<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    public function toArray($request) {
        return $this->resource->only([
            'id',
            'name',
            'price',
            'stock',
            'details',
        ]);
    }
}
