<?php

namespace App\Http\Resources\Appropriation;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingReportsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'academic_group' => optional(optional($this->exam_schedule)->academic_group)->name,
            'subject' => optional($this->subject)->name,
            'exam_type' => optional($this->exam_type)->name,
            'final_exam_position' => $this->final_exam_position,
            'academic_year' => optional(optional(optional($this->exam_schedule)->semester)->academic_year)->name,
            'semester' => optional(optional($this->exam_schedule)->semester)->semester,
        ];
    }
}