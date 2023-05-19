<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'last_name' => $this->last_name,
            'faculty' => optional($this->department)->name,
            'edu_type' => optional(optional($this->specialty)->edu_type)->name,
            'edu_form' => optional(optional(optional($this->academic_group)->edu_plan)->edu_form)->name,
            'semester' => optional($this->semester)->semester,
        ];
    }
}