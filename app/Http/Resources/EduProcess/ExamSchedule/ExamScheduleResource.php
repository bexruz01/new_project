<?php

namespace App\Http\Resources\EduProcess\ExamSchedule;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamScheduleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'edu_plan' => optional(optional($this->semester)->eduPlan)->name,
            'academic_year' => optional(optional($this->semester)->academicYear)->name,
            'semester' => optional($this->semester)->semester,
            'academic_group' => optional($this->academic_group)->name,
            // 'week_count' => $this->week_count,
            // 'list' => SubjectsResource::collection($this->exam_schedule_subjects),
        ];
    }
}