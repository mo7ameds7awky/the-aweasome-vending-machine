<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'productName' => $this->productName,
            'amountAvailable' => $this->amountAvailable,
            'cost' => $this->cost,
            'sellerId' => $this->sellerId,
        ];
    }
}
