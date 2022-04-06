<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'nextPageUrl' => $this->nextPageUrl(),
            'previousPageUrl' => $this->previousPageUrl(),
            'itemsPerPage' => $this->perPage(),
            'itemsCount' => $this->count(),
            'totalCount' => $this->total()
        ];
    }
}
