<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "group_id" => $this->group_id,
            "message" => $this->message,
            "user" => UserResource::make($this->user),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
