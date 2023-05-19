<?php

namespace App\Http\Resources\UserProfile;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'full_name' => $this->employee?->full_name,
            'email' => $this->employee?->email,
            'image' => $this->employee?->image,
            'phone' => $this->employee?->phone,
        ];
    }
}