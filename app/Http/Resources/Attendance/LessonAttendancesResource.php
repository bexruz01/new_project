<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee' => $this->employee?->full_name,
            'department' => optional(optional(optional($this->employee)->work_contract)->department)->name,
            'academic_group' => optional(optional($this->lesson_schedule)->academic_group)->name,
            'faculty' => optional(optional(optional(optional($this->lesson_schedule)->academic_group)->edu_plan)->faculty)->name,
            'subject' => optional($this->subject)->name,
            'subject_type' => optional($this->lesson_activity)->name,
            /** Dars haqida */
            'position' => optional($this->pair)->position,
            'time_start' => optional($this->pair)->time_start,
            'time_end' => optional($this->pair)->time_end,
            'date' => $this->date,
        ];
    }
}