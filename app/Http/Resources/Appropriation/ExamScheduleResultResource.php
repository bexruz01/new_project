<?php

namespace App\Http\Resources\Appropriation;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamScheduleResultResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'subject' => optional(optional($this->exam_schedule_subject)->subject)->name,
            'final_exam_position' => optional($this->exam_schedule_subject)->final_exam_position,
            'rating' => $this->rating,
        ];
    }
}