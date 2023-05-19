<?php

namespace App\Http\Resources\SelectData;

use Illuminate\Http\Resources\Json\JsonResource;

class EduPlanSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->academic_year?->year,
        ];
    }
}