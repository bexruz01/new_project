<?php

namespace App\Http\Resources\Messages;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "name" => $this->name,
            "surname" => $this->surname,
            "patronymic" => $this->patronymic,
            "image" => $this->image,
        ];
    }
}