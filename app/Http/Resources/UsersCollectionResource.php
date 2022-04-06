<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersCollectionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'users' => UsersResource::collection($this->items()),
            'links' => new PaginationResource($this)
        ];
    }
}
