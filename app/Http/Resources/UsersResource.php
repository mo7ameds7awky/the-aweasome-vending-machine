<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'deposit' => $this->username,
            'userRole' => new UserRoleResource($this->userRole)
        ];
    }
}
