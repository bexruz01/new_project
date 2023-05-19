<?php

namespace App\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherRatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'full_name' => $this->employee?->full_name,
            'critery' => $this->publication?->rating_critery?->critery?->name,
            'publication_type' => $this->publication?->rating_critery?->publication_type?->name,
            'publication' => $this->publication?->name,
            'ball' => $this->rating_critery?->ball,
        ];
    }
}