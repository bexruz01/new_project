<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'full_name' => $this->student?->full_name,
            'academic_group' => $this->student?->academic_group?->name,
            'subject' => $this->lesson_schedule_topic?->subject?->name,
            'audience' => $this->lesson_schedule_topic?->audience?->name,
            'load' => $this->lesson_schedule_topic?->subject_topic?->load,
            'because_of' => $this->because_of,
            'not_because_of' => $this->not_because_of,
            'total_nb' => $this->total_nb,
            'prosent' => $this->totalProsent(),
        ];
    }

    public function totalProsent()
    {
        if ($this->lesson_schedule_topic?->subject_topic?->load)
            return round(200 * $this->total_nb / $this->lesson_schedule_topic->subject_topic->load, 2);
        return 0;
    }
}