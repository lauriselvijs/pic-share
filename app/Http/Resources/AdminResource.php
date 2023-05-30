<?php

namespace App\Http\Resources;

use App\Http\Resources\AdminRoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'admin_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => AdminRoleResource::collection($this->roles),
            'notify' => $this->notify,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
