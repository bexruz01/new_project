<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeAttendancesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'teacher' => $this->full_name,
            'department' => optional(optional($this->work_contract)->department)->name,
            'count' => $this->lesson_schedule_topics->count(),
        ];
    }
}