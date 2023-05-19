<?php

namespace App\Http\Resources\Appropriation;

use Illuminate\Http\Resources\Json\JsonResource;

class AcademicDebtAppropriationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'student' => optional($this->student)->full_name,
            'academic_group' => optional(optional($this->student)->academic_group)->name,
            'academic_year' => optional(optional(optional($this->student)->semester)->academic_year)->name,
            'semester' => optional(optional($this->student)->semester)->semester,
            'subject' => optional(optional($this->exam_schedule_subject)->subject)->name,
        ];
    }
}