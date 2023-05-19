<?php

namespace App\Http\Resources\SelectData;

use Illuminate\Http\Resources\Json\JsonResource;

class SemesterSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->semester,
            'year' => $this->academic_year?->year,
            'edu_plan_id' => $this->edu_plan_id,

        ];
    }
}