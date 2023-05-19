<?php

namespace App\Http\Resources\Employees;

use App\Http\Resources\LanguageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'status' => $this->status,
            'full_name' => $this->full_name,
            'avatar' => $this->avatar,
            'language' => new LanguageResource($this->language)
        ];
    }
}