<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "users" => $this->whenLoaded('users', fn() => UserResource::collection($this->users)),
            "messages" => $this->whenLoaded('messages', fn() => MessageResource::collection($this->messages)),
            'avatar' => $this->avatar,
            "created_at" => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
