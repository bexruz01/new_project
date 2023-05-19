<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class CountStudentSocialStatisticResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->social_category?->id,
            'name' => $this->social_category?->name,
            'autumn_count' => $this->autumn_count,
            'spring_count' => $this->spring_count,
            'full_count' => $this->full_count,
        ];
    }
}