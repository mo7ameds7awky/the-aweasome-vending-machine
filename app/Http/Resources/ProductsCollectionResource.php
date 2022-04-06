<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsCollectionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'products' => ProductsResource::collection($this->items()),
            'links' => new PaginationResource($this)
        ];
    }
}
