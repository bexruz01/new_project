<?php

namespace App\Http\Resources\Appropriation;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'subject' => optional($this->subject)->name,
            'exam_type' => optional($this->exam_type)->name,
            'final_exam_position' => $this->final_exam_position,
            'date' => $this->date,
            'academic_group' => optional(optional($this->exam_schedule)->academic_group)->name,
            'max_rating' => optional($this->curriculum_exam_type)->value,
            'students' => ExamScheduleResultsResource::collection($this->exam_schedule_results),
        ];
    }
}